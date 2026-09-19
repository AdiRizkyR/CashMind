<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $accountId = $request->get('account_id');
        $categoryId = $request->get('category_id');

        $query = $user->transactions()->with(['account', 'category']);

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

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netCashFlow = $totalIncome - $totalExpense;

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
            'incomeBreakdown',
            'expenseBreakdown'
        ));
    }

    public function exportCsv(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        $transactions = $user->transactions()
            ->with(['account', 'category'])
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $filename = "laporan_keuangan_{$year}_{$month}.csv";

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Jenis', 'Rekening', 'Kategori', 'Uraian', 'Nominal (Rp)']);

            foreach ($transactions as $t) {
                fputcsv($file, [
                    $t->transaction_date->format('Y-m-d'),
                    strtoupper($t->type),
                    $t->account?->name ?? '-',
                    $t->category?->name ?? '-',
                    $t->description ?? '-',
                    $t->amount,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
