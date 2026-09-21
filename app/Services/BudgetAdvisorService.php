<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;

class BudgetAdvisorService
{
    /**
     * Generate Machine Learning / Smart Heuristic Budget Allocation Recommendations.
     */
    public function generateRecommendation(User $user, int $month, int $year): array
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

        // Calculate baseline monthly income (from profile or 3-month average income)
        $profileIncome = (float) $profile->monthly_income;
        if ($profileIncome <= 0) {
            $profileIncome = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereBetween('transaction_date', [Carbon::now()->subMonths(3), Carbon::now()])
                ->avg('amount') ?: 5000000;
        }

        // Get expense categories available to this user
        $disabledCatIds = \App\Models\UserCategoryToggle::where('user_id', $user->id)
            ->where('is_active', false)
            ->pluck('category_id')
            ->toArray();

        $expenseCategories = Category::where('type', 'expense')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('is_system', true);
            })
            ->whereNotIn('id', $disabledCatIds)
            ->get();

        // Goal-type base 50/30/20 ratio rule
        $ratios = $this->getGoalRatio($profile->financial_goal_type);
        
        // Dependents adjustment (+3% needs per dependent, up to 15%)
        $depAdj = min(0.15, $profile->dependents_count * 0.03);
        $needsRatio = min(0.70, $ratios['needs'] + $depAdj);
        $wantsRatio = max(0.10, $ratios['wants'] - $depAdj);
        $savingsRatio = $ratios['savings'];

        $totalNeedsPool = $profileIncome * $needsRatio;
        $totalWantsPool = $profileIncome * $wantsRatio;

        // Categorize expense categories into Needs vs Wants
        $needsKeywords = ['makan', 'food', 'tagihan', 'utility', 'listrik', 'air', 'sewa', 'rumah', 'kesehatan', 'health', 'transpor', 'pendidikan', 'groceries', 'kebutuhan'];
        
        $needsCats = [];
        $wantsCats = [];

        foreach ($expenseCategories as $cat) {
            $nameLower = strtolower($cat->name);
            $isNeed = false;
            foreach ($needsKeywords as $kw) {
                if (str_contains($nameLower, $kw)) {
                    $isNeed = true;
                    break;
                }
            }
            if ($isNeed) {
                $needsCats[] = $cat;
            } else {
                $wantsCats[] = $cat;
            }
        }

        if (empty($needsCats)) $needsCats = $expenseCategories->all();

        // Calculate historical category weights based on past 60 days transactions
        $categoryHistory = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('transaction_date', '>=', Carbon::now()->subDays(60))
            ->selectRaw('category_id, SUM(amount) as total_spent')
            ->groupBy('category_id')
            ->pluck('total_spent', 'category_id')
            ->toArray();

        // Build per-category recommendation
        $recommendations = [];
        $totalRecommendedBudget = 0;

        // Needs categories allocation
        $needsShare = count($needsCats) > 0 ? ($totalNeedsPool / count($needsCats)) : 0;
        foreach ($needsCats as $cat) {
            $historicalSpent = (float) ($categoryHistory[$cat->id] ?? 0);
            $baseRec = $needsShare;

            if ($historicalSpent > 0) {
                // Machine learning weighted average between rule-base (40%) and historical spending (60%)
                $baseRec = ($needsShare * 0.4) + (($historicalSpent / 2) * 0.6);
            }

            $roundedRec = round($baseRec / 50000) * 50000;
            if ($roundedRec < 100000) $roundedRec = 100000;

            $currentBudget = $user->budgets()
                ->where('category_id', $cat->id)
                ->where('period_month', $month)
                ->where('period_year', $year)
                ->first();

            $currentAmount = $currentBudget ? (float) $currentBudget->amount : 0;

            $recommendations[] = [
                'category_id' => $cat->id,
                'category_name' => $cat->name,
                'type_group' => 'Kebutuhan Utama (Needs)',
                'recommended_amount' => $roundedRec,
                'current_amount' => $currentAmount,
                'percentage' => round(($roundedRec / $profileIncome) * 100, 1),
                'reason' => 'Alokasi kebutuhan primer berdasarkan formula 50/30/20 & tanggungan ' . $profile->dependents_count . ' orang.',
            ];

            $totalRecommendedBudget += $roundedRec;
        }

        // Wants categories allocation
        $wantsShare = count($wantsCats) > 0 ? ($totalWantsPool / count($wantsCats)) : 0;
        foreach ($wantsCats as $cat) {
            $historicalSpent = (float) ($categoryHistory[$cat->id] ?? 0);
            $baseRec = $wantsShare;

            if ($historicalSpent > 0) {
                $baseRec = ($wantsShare * 0.5) + (($historicalSpent / 2) * 0.5);
            }

            $roundedRec = round($baseRec / 50000) * 50000;
            if ($roundedRec < 50000) $roundedRec = 50000;

            $currentBudget = $user->budgets()
                ->where('category_id', $cat->id)
                ->where('period_month', $month)
                ->where('period_year', $year)
                ->first();

            $currentAmount = $currentBudget ? (float) $currentBudget->amount : 0;

            $recommendations[] = [
                'category_id' => $cat->id,
                'category_name' => $cat->name,
                'type_group' => 'Gaya Hidup & Keinginan (Wants)',
                'recommended_amount' => $roundedRec,
                'current_amount' => $currentAmount,
                'percentage' => round(($roundedRec / $profileIncome) * 100, 1),
                'reason' => 'Alokasi gaya hidup disesuaikan dengan profil risiko ' . ucfirst($profile->risk_profile) . '.',
            ];

            $totalRecommendedBudget += $roundedRec;
        }

        // Calculate Financial Health Score (0-100)
        $savingsAmount = max(0, $profileIncome - $totalRecommendedBudget);
        $savingsRatioActual = $profileIncome > 0 ? ($savingsAmount / $profileIncome) : 0;
        $healthScore = min(100, max(20, round(($savingsRatioActual / 0.20) * 70 + (count($recommendations) > 0 ? 30 : 0))));

        // Schedule label & Trigger frequency text
        $scheduleLabel = match($profile->recommendation_frequency) {
            'payday' => 'Setiap Gaji Masuk (Tanggal ' . $profile->payday_date . ')',
            'weekly' => 'Setiap Minggu',
            'manual' => 'Manual Saja',
            default => 'Setiap Awal Bulan',
        };

        return [
            'monthly_income' => $profileIncome,
            'health_score' => $healthScore,
            'total_recommended_budget' => $totalRecommendedBudget,
            'recommended_savings' => max(0, $profileIncome - $totalRecommendedBudget),
            'schedule_label' => $scheduleLabel,
            'recommendation_frequency' => $profile->recommendation_frequency,
            'goal_type' => $profile->financial_goal_type,
            'dependents_count' => $profile->dependents_count,
            'recommendations' => $recommendations,
        ];
    }

    private function getGoalRatio(string $goalType): array
    {
        return match ($goalType) {
            'saving_focused' => ['needs' => 0.45, 'wants' => 0.25, 'savings' => 0.30],
            'debt_reduction' => ['needs' => 0.50, 'wants' => 0.20, 'savings' => 0.30],
            'frugal' => ['needs' => 0.60, 'wants' => 0.15, 'savings' => 0.25],
            default => ['needs' => 0.50, 'wants' => 0.30, 'savings' => 0.20],
        };
    }
}
