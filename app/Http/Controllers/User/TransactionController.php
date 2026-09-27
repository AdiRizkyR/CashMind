<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\UserCategoryToggle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $tab = $request->get('tab', 'all'); // income, expenses, transfer, all

        $query = $user->transactions()->with(['account', 'destinationAccount', 'category']);

        if ($tab === 'income') {
            $query->where('type', 'income');
        } elseif ($tab === 'expenses') {
            $query->where('type', 'expense');
        } elseif ($tab === 'transfer') {
            $query->where('type', 'transfer');
        } elseif ($request->filled('type') && in_array($request->type, ['income', 'expense', 'transfer', 'adjustment'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('account_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('account_id', $request->account_id)
                    ->orWhere('destination_account_id', $request->account_id);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%'.$request->search.'%')
                  ->orWhere('note', 'like', '%'.$request->search.'%');
            });
        }

        if ($month) {
            $query->whereMonth('transaction_date', $month);
        }

        if ($year) {
            $query->whereYear('transaction_date', $year);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $accounts = $user->accounts()->where('is_active', true)->get();
        
        $disabledSystemCatIds = UserCategoryToggle::where('user_id', $user->id)
            ->where('is_active', false)
            ->pluck('category_id')
            ->toArray();

        $categories = $user->categories()->where('is_active', true)->get()->concat(
            Category::where('is_system', true)
                ->where('is_active', true)
                ->whereNotIn('id', $disabledSystemCatIds)
                ->get()
        );

        $incomeCategories = $categories->where('type', 'income');
        $expenseCategories = $categories->where('type', 'expense');

        // Calculate Totals for active month/year
        $monthIncomeTotal = (float) $user->transactions()
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $monthExpenseTotal = (float) $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        // Active Budgets for Month Expense Tab Allocation
        $budgets = $user->budgets()
            ->with('category')
            ->where('period_month', $month)
            ->where('period_year', $year)
            ->get();

        return view('user.transactions', compact(
            'transactions',
            'accounts',
            'categories',
            'incomeCategories',
            'expenseCategories',
            'month',
            'year',
            'tab',
            'monthIncomeTotal',
            'monthExpenseTotal',
            'budgets'
        ));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer,adjustment',
            'amount' => 'required|numeric|min:1',
            'admin_fee' => 'nullable|numeric|min:0',
            'account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|required_if:type,transfer|exists:accounts,id|different:account_id',
            'category_id' => 'nullable|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $sourceAccount = $user->accounts()->findOrFail($validated['account_id']);
        
        if (! empty($validated['destination_account_id'])) {
            $user->accounts()->findOrFail($validated['destination_account_id']);
        }

        // Transfer balance validation
        if ($validated['type'] === 'transfer') {
            $adminFee = (float) ($validated['admin_fee'] ?? 0);
            $totalDeduction = (float) $validated['amount'] + $adminFee;
            if ($sourceAccount->balance < $totalDeduction) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['amount' => 'Saldo rekening sumber (Rp '.number_format($sourceAccount->balance, 0, ',', '.').') tidak mencukupi untuk transfer Rp '.number_format($totalDeduction, 0, ',', '.').' (termasuk biaya admin).']);
            }
        }

        DB::transaction(function () use ($user, $validated) {
            $adminFee = (float) ($validated['admin_fee'] ?? 0);
            $transaction = $user->transactions()->create($validated);

            // If transfer has admin fee, create separate Expense transaction for Biaya Admin/Bank Fee
            if ($validated['type'] === 'transfer' && $adminFee > 0) {
                $bankFeeCategory = Category::where('name', 'like', '%Admin%')
                    ->orWhere('name', 'like', '%Bank%')
                    ->orWhere('name', 'like', '%Tagihan%')
                    ->first();

                $user->transactions()->create([
                    'account_id' => $validated['account_id'],
                    'category_id' => $bankFeeCategory?->id,
                    'type' => 'expense',
                    'amount' => $adminFee,
                    'transaction_date' => $validated['transaction_date'],
                    'description' => 'Biaya Admin Transfer ('.$transaction->description.')',
                    'note' => 'Otomatis dicatat dari transfer #'.$transaction->id,
                    'transfer_reference_id' => (string) $transaction->id,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $user = $request->user();

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer,adjustment',
            'amount' => 'required|numeric|min:1',
            'admin_fee' => 'nullable|numeric|min:0',
            'account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|required_if:type,transfer|exists:accounts,id|different:account_id',
            'category_id' => 'nullable|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $user->accounts()->findOrFail($validated['account_id']);
        if (! empty($validated['destination_account_id'])) {
            $user->accounts()->findOrFail($validated['destination_account_id']);
        }

        DB::transaction(function () use ($transaction, $validated, $user) {
            $transaction->update($validated);

            // Clean up old admin fee transaction linked to this transfer
            Transaction::where('user_id', $user->id)
                ->where('transfer_reference_id', (string) $transaction->id)
                ->delete();

            $adminFee = (float) ($validated['admin_fee'] ?? 0);
            if ($validated['type'] === 'transfer' && $adminFee > 0) {
                $bankFeeCategory = Category::where('name', 'like', '%Admin%')
                    ->orWhere('name', 'like', '%Bank%')
                    ->first();

                $user->transactions()->create([
                    'account_id' => $validated['account_id'],
                    'category_id' => $bankFeeCategory?->id,
                    'type' => 'expense',
                    'amount' => $adminFee,
                    'transaction_date' => $validated['transaction_date'],
                    'description' => 'Biaya Admin Transfer ('.$transaction->description.')',
                    'note' => 'Otomatis dicatat dari transfer #'.$transaction->id,
                    'transfer_reference_id' => (string) $transaction->id,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $user = $request->user();

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($user, $transaction) {
            // Delete associated admin fee transaction if present
            Transaction::where('user_id', $user->id)
                ->where('transfer_reference_id', (string) $transaction->id)
                ->delete();

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function storeBudget(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'allocation_type' => 'required|in:nominal,percentage',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2020|max:2100',
        ]);

        Budget::updateOrCreate(
            [
                'user_id' => $user->id,
                'category_id' => $validated['category_id'],
                'period_month' => $validated['period_month'],
                'period_year' => $validated['period_year'],
            ],
            [
                'amount' => $validated['amount'],
                'allocation_type' => $validated['allocation_type'],
            ]
        );

        return redirect()->back()->with('success', 'Alokasi budget kategori berhasil disimpan.');
    }
}
