<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;

class FinancialReportAdvisorService
{
    /**
     * Generate Machine Learning / Heuristic Financial Report Analysis for a given month/year.
     */
    public function generateMonthlyAnalysis(User $user, int $month, int $year): array
    {
        $profile = $user->profile ?: $user->profile()->create([
            'monthly_income' => 0,
            'payday_date' => 25,
            'payday_frequency' => 'monthly',
            'financial_goal_type' => 'balanced',
            'dependents_count' => 0,
            'risk_profile' => 'moderate',
            'recommendation_frequency' => 'month_start',
        ]);

        // Get monthly transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->with('category')
            ->get();

        $totalIncome = (float) $transactions->where('type', 'income')->sum('amount');
        $totalExpense = (float) $transactions->where('type', 'expense')->sum('amount');
        $netCashFlow = $totalIncome - $totalExpense;

        // Baseline income comparison (profile income vs actual income)
        $baselineIncome = max($totalIncome, (float) $profile->monthly_income, 1);
        
        // Savings rate
        $savingsRate = $totalIncome > 0 ? max(0, ($netCashFlow / $totalIncome) * 100) : 0;

        // Categorize expenses into Needs vs Wants vs Others
        $needsKeywords = ['makan', 'food', 'tagihan', 'utility', 'listrik', 'air', 'sewa', 'rumah', 'kesehatan', 'health', 'transpor', 'pendidikan', 'groceries', 'kebutuhan'];

        $expenseTransactions = $transactions->where('type', 'expense');
        $needsTotal = 0;
        $wantsTotal = 0;

        $categoryExpenses = [];

        foreach ($expenseTransactions as $t) {
            $catName = $t->category?->name ?? 'Lainnya';
            $catId = $t->category_id ?? 0;

            if (!isset($categoryExpenses[$catId])) {
                $categoryExpenses[$catId] = [
                    'id' => $catId,
                    'name' => $catName,
                    'total' => 0,
                    'is_need' => false,
                ];
            }

            $categoryExpenses[$catId]['total'] += (float) $t->amount;

            $nameLower = strtolower($catName);
            $isNeed = false;
            foreach ($needsKeywords as $kw) {
                if (str_contains($nameLower, $kw)) {
                    $isNeed = true;
                    break;
                }
            }

            if ($isNeed) {
                $categoryExpenses[$catId]['is_need'] = true;
                $needsTotal += (float) $t->amount;
            } else {
                $wantsTotal += (float) $t->amount;
            }
        }

        // Calculate User Active Budgets for adherence score
        $userBudgets = $user->budgets()
            ->where('period_month', $month)
            ->where('period_year', $year)
            ->get();

        $totalBudgetsCount = $userBudgets->count();
        $overBudgetsCount = 0;
        $safeBudgetsCount = 0;

        foreach ($userBudgets as $b) {
            if ($b->status === 'Over') {
                $overBudgetsCount++;
            } else {
                $safeBudgetsCount++;
            }
        }

        // Financial Health Score Calculation (0 - 100)
        $healthScore = 50; // base score
        
        if ($netCashFlow > 0) {
            $healthScore += 20;
        } elseif ($netCashFlow < 0) {
            $healthScore -= 25;
        }

        if ($savingsRate >= 20) {
            $healthScore += 20;
        } elseif ($savingsRate >= 10) {
            $healthScore += 10;
        } else {
            $healthScore -= 10;
        }

        if ($totalBudgetsCount > 0) {
            $budgetAdherenceRatio = $safeBudgetsCount / $totalBudgetsCount;
            $healthScore += (int) round($budgetAdherenceRatio * 10);
        }

        $healthScore = min(100, max(10, $healthScore));

        // 1. POIN PLUS (KELEBIHAN PENGELOLAAN DANA)
        $poinPlus = [];

        if ($netCashFlow > 0) {
            $poinPlus[] = [
                'title' => 'Surplus Arus Kas Positif',
                'description' => 'Pendapatan bulan ini melebihi pengeluaran sebesar Rp ' . number_format($netCashFlow, 0, ',', '.') . ', memberikan ruang napas finansial.',
            ];
        }

        if ($savingsRate >= 20) {
            $poinPlus[] = [
                'title' => 'Rasio Tabungan Sangat Sehat (' . round($savingsRate, 1) . '%)',
                'description' => 'Anda berhasil mengalokasikan ' . round($savingsRate, 1) . '% pendapatan untuk tabungan & investasi, di atas standar acuan 20%.',
            ];
        } elseif ($savingsRate > 0) {
            $poinPlus[] = [
                'title' => 'Menyisihkan Tabungan (' . round($savingsRate, 1) . '%)',
                'description' => 'Anda tetap dapat menyisihkan dana tabungan di akhir bulan.',
            ];
        }

        if ($totalBudgetsCount > 0 && $overBudgetsCount === 0) {
            $poinPlus[] = [
                'title' => 'Disiplin Anggaran 100%',
                'description' => 'Seluruh kategori pengeluaran terencana berhasil dijaga dalam batas anggaran aman yang Anda tetapkan.',
            ];
        }

        $wantsRatio = $baselineIncome > 0 ? ($wantsTotal / $baselineIncome) * 100 : 0;
        if ($wantsRatio <= 30 && $wantsTotal > 0) {
            $poinPlus[] = [
                'title' => 'Pengeluaran Gaya Hidup Terkontrol (' . round($wantsRatio, 1) . '%)',
                'description' => 'Proporsi pengeluaran gaya hidup & keinginan tetap terkendali di bawah ambang batas 30%.',
            ];
        }

        if (empty($poinPlus)) {
            $poinPlus[] = [
                'title' => 'Pencatatan Transaksi Aktif',
                'description' => 'Anda konsisten mengukur arus kas bulanan untuk transparansi kondisi keuangan pribadi.',
            ];
        }

        // 2. POIN MINUS (KEKURANGAN & RISIKO FINANSIAL)
        $poinMinus = [];

        if ($netCashFlow < 0) {
            $poinMinus[] = [
                'title' => 'Defisit Arus Kas (Rp ' . number_format(abs($netCashFlow), 0, ',', '.') . ')',
                'description' => 'Pengeluaran bulan ini melebihi pendapatan. Segera evaluasi pengeluaran non-pokok untuk menghentikan penurunan saldo.',
            ];
        }

        if ($overBudgetsCount > 0) {
            $poinMinus[] = [
                'title' => $overBudgetsCount . ' Kategori Melebihi Limit Anggaran',
                'description' => 'Terdapat ' . $overBudgetsCount . ' kategori pengeluaran yang melampaui batas anggaran yang Anda tentukan.',
            ];
        }

        // Find highest expense category
        usort($categoryExpenses, fn($a, $b) => $b['total'] <=> $a['total']);
        $highestExpense = $categoryExpenses[0] ?? null;

        if ($highestExpense && $totalExpense > 0) {
            $highestPct = ($highestExpense['total'] / $totalExpense) * 100;
            if ($highestPct >= 35) {
                $poinMinus[] = [
                    'title' => 'Dominasi Pengeluaran: ' . $highestExpense['name'] . ' (' . round($highestPct, 1) . '%)',
                    'description' => 'Kategori ini menyerap ' . round($highestPct, 1) . '% dari total seluruh pengeluaran bulanan Anda (Rp ' . number_format($highestExpense['total'], 0, ',', '.') . ').',
                ];
            }
        }

        if ($savingsRate < 10 && $netCashFlow >= 0) {
            $poinMinus[] = [
                'title' => 'Rasio Alokasi Tabungan Rendah (' . round($savingsRate, 1) . '%)',
                'description' => 'Alokasi tabungan masih di bawah rekomendasi ideal 10-20% dari total pendapatan.',
            ];
        }

        if (empty($poinMinus)) {
            $poinMinus[] = [
                'title' => 'Tidak Ada Kebocoran Finansial Signifikan',
                'description' => 'Pengelolaan keuangan bulan ini berjalan stabil tanpa indikasi defisit atau kebiasaan boros.',
            ];
        }

        // 3. ANALISIS EFISIENSI PENGALOKASIAN DANA (Needs vs Wants vs Savings)
        $needsPct = $baselineIncome > 0 ? round(($needsTotal / $baselineIncome) * 100, 1) : 0;
        $wantsPct = $baselineIncome > 0 ? round(($wantsTotal / $baselineIncome) * 100, 1) : 0;
        $savingsPct = round($savingsRate, 1);

        $allocationEfficiency = [
            'needs' => [
                'actual_amount' => $needsTotal,
                'actual_pct' => $needsPct,
                'ideal_pct' => 50,
                'status' => $needsPct <= 55 ? 'Ideal' : 'Berlebihan',
            ],
            'wants' => [
                'actual_amount' => $wantsTotal,
                'actual_pct' => $wantsPct,
                'ideal_pct' => 30,
                'status' => $wantsPct <= 30 ? 'Ideal' : 'Perlu Diwaspadai',
            ],
            'savings' => [
                'actual_amount' => max(0, $netCashFlow),
                'actual_pct' => $savingsPct,
                'ideal_pct' => 20,
                'status' => $savingsPct >= 20 ? 'Optimal' : ($savingsPct >= 10 ? 'Cukup' : 'Kurang'),
            ],
        ];

        // 4. REKOMENDASI TAKTIS BULAN DEPAN
        $recommendations = [];

        if ($netCashFlow < 0) {
            $recommendations[] = 'Tetapkan prioritas pemotongan anggaran minimal 15-20% pada kategori non-pokok seperti gaya hidup untuk memulihkan arus kas positif.';
        }

        if ($highestExpense && ($highestExpense['total'] / max($totalExpense, 1)) >= 0.3) {
            $recommendations[] = 'Lakukan evaluasi khusus pada kategori "' . $highestExpense['name'] . '". Cobalah mencari alternatif yang lebih hemat untuk menghemat nominal bulanan.';
        }

        if ($savingsRate < 20) {
            $recommendations[] = 'Terapkan metode "Pay Yourself First": Otomatiskan setoran simpanan atau dana darurat di awal bulan saat menerima gaji.';
        }

        if ($totalBudgetsCount === 0) {
            $recommendations[] = 'Buatlah batas anggaran (Budget) kustom pada menu Perencanaan Anggaran untuk memantau pengeluaran harian secara lebih terukur.';
        } else {
            $recommendations[] = 'Pertahankan disiplin evaluasi mingguan pada batas anggaran yang telah Anda tentukan.';
        }

        return [
            'health_score' => $healthScore,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net_cash_flow' => $netCashFlow,
            'savings_rate' => round($savingsRate, 1),
            'poin_plus' => $poinPlus,
            'poin_minus' => $poinMinus,
            'allocation_efficiency' => $allocationEfficiency,
            'recommendations' => $recommendations,
            'highest_expense' => $highestExpense,
        ];
    }
}
