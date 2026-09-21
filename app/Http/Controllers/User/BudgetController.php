<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Category;
use App\Services\BudgetAdvisorService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BudgetController extends Controller
{
    protected BudgetAdvisorService $advisorService;

    public function __construct(BudgetAdvisorService $advisorService)
    {
        $this->advisorService = $advisorService;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        $budgets = $user->budgets()
            ->with('category')
            ->where('period_month', $month)
            ->where('period_year', $year)
            ->get();

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

        // Generate Machine Learning / Smart Heuristic Budget Recommendation
        $mlRecommendation = $this->advisorService->generateRecommendation($user, $month, $year);

        return view('user.budget', compact('budgets', 'month', 'year', 'expenseCategories', 'mlRecommendation'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'period_month' => 'required|integer|between:1,12',
            'period_year' => 'required|integer|min:2020|max:2030',
            'amount' => 'required|numeric|min:1000',
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
            ]
        );

        return redirect()->back()->with('success', 'Anggaran berhasil disimpan.');
    }

    public function applyAiRecommendation(Request $request)
    {
        $user = $request->user();

        $month = (int) $request->input('period_month', Carbon::now()->month);
        $year = (int) $request->input('period_year', Carbon::now()->year);

        $mlData = $this->advisorService->generateRecommendation($user, $month, $year);

        foreach ($mlData['recommendations'] as $rec) {
            Budget::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $rec['category_id'],
                    'period_month' => $month,
                    'period_year' => $year,
                ],
                [
                    'amount' => $rec['recommended_amount'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Rekomendasi ML alokasi anggaran berhasil diterapkan secara otomatis untuk ' . Carbon::create(null, $month, 1)->translatedFormat('F') . ' ' . $year . '.');
    }

    public function destroy(Request $request, Budget $budget)
    {
        $user = $request->user();

        if ($budget->user_id !== $user->id) {
            abort(403);
        }

        $budget->delete();

        return redirect()->back()->with('success', 'Anggaran berhasil dihapus.');
    }
}
