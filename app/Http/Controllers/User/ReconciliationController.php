<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reconciliation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReconciliationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        // Calculate Saldo Seharusnya = Total Pemasukan - Total Pengeluaran for selected period
        $totalIncome = (float) $user->transactions()
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $totalExpense = (float) $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $theoreticalBalance = $totalIncome - $totalExpense;

        $accounts = $user->accounts()->where('is_active', true)->get();
        $totalActualAccountBalance = $accounts->sum(fn ($acc) => $acc->balance);

        $reconciliations = $user->reconciliations()
            ->with('account')
            ->orderBy('reconciled_at', 'desc')
            ->get();

        return view('user.reconciliation', compact(
            'month',
            'year',
            'totalIncome',
            'totalExpense',
            'theoreticalBalance',
            'accounts',
            'totalActualAccountBalance',
            'reconciliations'
        ));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'actual_balance' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
            'create_adjustment' => 'nullable|boolean',
        ]);

        $account = $user->accounts()->findOrFail($validated['account_id']);
        $systemBalance = $account->balance;
        $actualBalance = (float) $validated['actual_balance'];
        $difference = $actualBalance - $systemBalance;

        // Save missing budget reconciliation log
        $reconciliation = $user->reconciliations()->create([
            'account_id' => $account->id,
            'system_balance' => $systemBalance,
            'actual_balance' => $actualBalance,
            'difference' => $difference,
            'reconciled_at' => Carbon::now(),
            'note' => $validated['note'] ?? 'Pemeriksaan Missing Budget / Selisih Dana',
        ]);

        // Create adjustment transaction if requested and difference != 0
        if ($request->boolean('create_adjustment') && $difference != 0) {
            Transaction::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'type' => 'adjustment',
                'amount' => abs($difference),
                'transaction_date' => Carbon::now()->toDateString(),
                'description' => 'Penyesuaian Selisih Missing Budget ('.($difference > 0 ? '+' : '-').'Rp '.number_format(abs($difference), 0, ',', '.').')',
                'note' => 'Penyesuaian fisik vs pencatatan pada '.Carbon::now()->format('d M Y H:i'),
            ]);
        }

        return redirect()->back()->with('success', 'Deteksi selisih Missing Budget berhasil dicatat.');
    }
}
