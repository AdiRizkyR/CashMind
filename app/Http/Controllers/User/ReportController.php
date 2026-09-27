<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\FinancialReportAdvisorService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    protected FinancialReportAdvisorService $reportAdvisorService;

    public function __construct(FinancialReportAdvisorService $reportAdvisorService)
    {
        $this->reportAdvisorService = $reportAdvisorService;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $accountId = $request->get('account_id');
        $categoryId = $request->get('category_id');

        // Check if selected period is completed
        $periodDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $isPeriodCompleted = $periodDate->isPast();

        $query = $user->transactions()->with(['account', 'destinationAccount', 'category']);

        if ($month) {
            $query->whereMonth('transaction_date', $month);
        }
        if ($year) {
            $query->whereYear('transaction_date', $year);
        }
        if ($accountId) {
            $query->where(function ($q) use ($accountId) {
                $q->where('account_id', $accountId)->orWhere('destination_account_id', $accountId);
            });
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        $totalIncome = (float) $transactions->where('type', 'income')->sum('amount');
        $totalExpense = (float) $transactions->where('type', 'expense')->sum('amount');
        $netCashFlow = $totalIncome - $totalExpense;
        $budgetUsageRate = $totalIncome > 0 ? round(($totalExpense / $totalIncome) * 100, 1) : 0;

        $accounts = $user->accounts()->where('is_active', true)->get();
        $categories = $user->categories()->get();

        // Income breakdown
        $incomeBreakdown = $transactions->where('type', 'income')->groupBy('category_id')->map(function ($items) {
            return [
                'category' => $items->first()->category?->name ?? 'Tanpa Kategori',
                'total' => $items->sum('amount'),
            ];
        });

        // Expense breakdown
        $expenseBreakdown = $transactions->where('type', 'expense')->groupBy('category_id')->map(function ($items) {
            return [
                'category' => $items->first()->category?->name ?? 'Tanpa Kategori',
                'total' => $items->sum('amount'),
            ];
        });

        // Breakdown by Media: Cash vs Transfer (Bank / E-Wallet)
        $cashTransactions = $transactions->filter(fn ($t) => optional($t->account)->type === 'cash');
        $transferTransactions = $transactions->filter(fn ($t) => in_array(optional($t->account)->type, ['bank', 'e_wallet', 'other']));

        $cashIncome = $cashTransactions->where('type', 'income')->sum('amount');
        $cashExpense = $cashTransactions->where('type', 'expense')->sum('amount');

        $transferIncome = $transferTransactions->where('type', 'income')->sum('amount');
        $transferExpense = $transferTransactions->where('type', 'expense')->sum('amount');
        $transferMovement = $transactions->where('type', 'transfer')->sum('amount');

        // Generate Machine Learning Financial Report Analysis
        $mlAnalysis = $this->reportAdvisorService->generateMonthlyAnalysis($user, $month, $year);

        return view('user.reports', compact(
            'month',
            'year',
            'accountId',
            'categoryId',
            'accounts',
            'categories',
            'transactions',
            'totalIncome',
            'totalExpense',
            'netCashFlow',
            'budgetUsageRate',
            'incomeBreakdown',
            'expenseBreakdown',
            'cashIncome',
            'cashExpense',
            'transferIncome',
            'transferExpense',
            'transferMovement',
            'isPeriodCompleted',
            'mlAnalysis'
        ));
    }

    public function exportCsv(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        $transactions = $user->transactions()
            ->with(['account', 'destinationAccount', 'category'])
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $filename = "cashmind_usage_summary_{$year}_{$month}.csv";

        $headers = [
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Tanggal', 'Jenis', 'Rekening Sumber', 'Rekening Tujuan', 'Kategori', 'Deskripsi / Catatan', 'Nominal (Rp)', 'Biaya Admin (Rp)']);

            foreach ($transactions as $t) {
                fputcsv($file, [
                    $t->transaction_date->format('Y-m-d'),
                    strtoupper($t->type),
                    $t->account?->name ?? '-',
                    $t->destinationAccount?->name ?? '-',
                    $t->category?->name ?? '-',
                    $t->description ?? $t->note ?? '-',
                    $t->amount,
                    $t->admin_fee ?? 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
