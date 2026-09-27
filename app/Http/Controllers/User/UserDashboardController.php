<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Global Month & Year selection
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        // Accounts list & total balance
        $accounts = $user->accounts()->where('is_active', true)->get();
        $totalBalance = $accounts->sum(fn ($acc) => $acc->balance);

        // Balance breakdown per account type
        $cashBalance = $accounts->where('type', 'cash')->sum(fn ($acc) => $acc->balance);
        $ewalletBalance = $accounts->where('type', 'e_wallet')->sum(fn ($acc) => $acc->balance);
        $bankBalance = $accounts->whereIn('type', ['bank', 'other'])->sum(fn ($acc) => $acc->balance);

        // Month Income & Expense
        $monthIncome = (float) $user->transactions()
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $monthExpense = (float) $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $netCashFlow = $monthIncome - $monthExpense;
        $budgetUsagePercentage = $monthIncome > 0 ? round(($monthExpense / $monthIncome) * 100, 1) : 0;

        // Category Budgets vs Realization Table
        $budgets = $user->budgets()
            ->with('category')
            ->where('period_month', $month)
            ->where('period_year', $year)
            ->get();

        // Income per Category
        $incomeCategoriesSummary = $user->transactions()
            ->selectRaw('category_id, SUM(amount) as total')
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Cash Flow Chart Data (Monthly Income vs Expense for selected year)
        $chartMonths = [];
        $incomeSeries = [];
        $expenseSeries = [];

        for ($m = 1; $m <= 12; $m++) {
            $date = Carbon::createFromDate($year, $m, 1);
            $chartMonths[] = $date->translatedFormat('M');

            $inc = (float) $user->transactions()
                ->where('type', 'income')
                ->whereMonth('transaction_date', $m)
                ->whereYear('transaction_date', $year)
                ->sum('amount');

            $exp = (float) $user->transactions()
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $m)
                ->whereYear('transaction_date', $year)
                ->sum('amount');

            $incomeSeries[] = $inc;
            $expenseSeries[] = $exp;
        }

        // Expense Breakdown Donut Chart Data
        $expenseCategoryData = $user->transactions()
            ->selectRaw('category_id, SUM(amount) as total')
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $categoryLabels = [];
        $categoryTotals = [];
        $totalExpenseForPercent = $expenseCategoryData->sum('total');

        foreach ($expenseCategoryData as $item) {
            $name = $item->category?->name ?? 'Lain-lain';
            $categoryLabels[] = $name;
            $categoryTotals[] = (float) $item->total;
        }

        // Transfer Dana summary (separate from Income & Expense chart)
        $monthTransfers = $user->transactions()
            ->with(['account', 'destinationAccount'])
            ->where('type', 'transfer')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Recent 5 Transactions
        $recentTransactions = $user->transactions()
            ->with(['account', 'destinationAccount', 'category'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'month',
            'year',
            'accounts',
            'totalBalance',
            'cashBalance',
            'ewalletBalance',
            'bankBalance',
            'monthIncome',
            'monthExpense',
            'netCashFlow',
            'budgetUsagePercentage',
            'budgets',
            'incomeCategoriesSummary',
            'chartMonths',
            'incomeSeries',
            'expenseSeries',
            'categoryLabels',
            'categoryTotals',
            'totalExpenseForPercent',
            'monthTransfers',
            'recentTransactions'
        ));
    }
}
