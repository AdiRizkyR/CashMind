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

        $accounts = $user->accounts()->where('is_active', true)->get();
        $reconciliations = $user->reconciliations()->with('account')->orderBy('reconciled_at', 'desc')->get();

        return view('user.reconciliation', compact('accounts', 'reconciliations'));
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

        // Save reconciliation log
        $reconciliation = $user->reconciliations()->create([
            'account_id' => $account->id,
            'system_balance' => $systemBalance,
            'actual_balance' => $actualBalance,
            'difference' => $difference,
            'reconciled_at' => Carbon::now(),
            'note' => $validated['note'] ?? 'Rekonsiliasi Kas / Saldo Akun',
        ]);

        // If adjustment requested and difference != 0, create adjustment transaction
        if ($request->boolean('create_adjustment') && $difference != 0) {
            Transaction::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'type' => 'adjustment',
                'amount' => $difference,
                'transaction_date' => Carbon::now()->toDateString(),
                'description' => 'Penyesuaian Saldo Rekonsiliasi ('.($difference > 0 ? '+' : '').'Rp '.number_format($difference, 0, ',', '.').')',
            ]);
        }

        return redirect()->back()->with('success', 'Rekonsiliasi saldo akun berhasil dicatat.');
    }
}
