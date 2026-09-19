<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserCategoryToggle;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // User custom categories
        $userExpenseCategories = $user->categories()->where('type', 'expense')->get();
        $userIncomeCategories = $user->categories()->where('type', 'income')->get();

        // System template categories with user toggles
        $systemCategories = Category::where('is_system', true)->get();
        $toggles = UserCategoryToggle::where('user_id', $user->id)->pluck('is_active', 'category_id')->toArray();

        $systemExpenseCategories = $systemCategories->where('type', 'expense')->map(function ($cat) use ($toggles) {
            $cat->user_active = isset($toggles[$cat->id]) ? (bool) $toggles[$cat->id] : true;

            return $cat;
        });

        $systemIncomeCategories = $systemCategories->where('type', 'income')->map(function ($cat) use ($toggles) {
            $cat->user_active = isset($toggles[$cat->id]) ? (bool) $toggles[$cat->id] : true;

            return $cat;
        });

        return view('user.categories', compact(
            'userExpenseCategories',
            'userIncomeCategories',
            'systemExpenseCategories',
            'systemIncomeCategories'
        ));
    }

    public function toggleSystem(Request $request, Category $category)
    {
        $user = $request->user();

        if (! $category->is_system) {
            abort(403);
        }

        $toggle = UserCategoryToggle::where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->first();

        $currentStatus = $toggle ? $toggle->is_active : true;
        $newStatus = ! $currentStatus;

        UserCategoryToggle::updateOrCreate(
            ['user_id' => $user->id, 'category_id' => $category->id],
            ['is_active' => $newStatus]
        );

        $statusText = $newStatus ? 'diaktifkan' : 'disembunyikan';

        return redirect()->back()->with('success', "Kategori sistem \"{$category->name}\" berhasil {$statusText}.");
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        $user->categories()->create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'icon' => $validated['icon'] ?? 'fa-solid fa-tag',
            'is_system' => false,
        ]);

        return redirect()->back()->with('success', 'Kategori kustom berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $user = $request->user();

        if ($category->user_id !== $user->id || $category->is_system) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category)
    {
        $user = $request->user();

        if ($category->user_id !== $user->id || $category->is_system) {
            abort(403);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
