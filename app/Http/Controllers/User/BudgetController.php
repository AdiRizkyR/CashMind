<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BudgetController extends Controller
{
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

        $expenseCategories = Category::where('type', 'expense')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('is_system', true);
            })->get();

        return view('user.budget', compact('budgets', 'month', 'year', 'expenseCategories'));
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

        return redirect()->back()->with('success', 'Anggaran anggaran berhasil disimpan.');
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
