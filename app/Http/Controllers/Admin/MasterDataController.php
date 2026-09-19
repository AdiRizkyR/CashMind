<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\FinancialInstitution;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $institutions = FinancialInstitution::all();
        $categoryTemplates = Category::where('is_system', true)->get();

        // Admin view: Aggregated user suggestions (names, types, icons ONLY - ZERO financial privacy exposure)
        $userCategorySuggestions = Category::where('is_system', false)
            ->whereNotIn('name', $categoryTemplates->pluck('name')->toArray())
            ->select('name', 'type', 'icon')
            ->distinct()
            ->get();

        $existingInstNames = $institutions->pluck('name')->toArray();
        $userAccountSuggestions = Account::select('name', 'type')
            ->whereNotIn('name', $existingInstNames)
            ->distinct()
            ->get();

        return view('admin.master_data', compact(
            'institutions',
            'categoryTemplates',
            'userCategorySuggestions',
            'userAccountSuggestions'
        ));
    }

    public function promoteCategoryTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::updateOrCreate(
            ['name' => $validated['name'], 'is_system' => true],
            [
                'user_id' => null,
                'type' => $validated['type'],
                'icon' => $validated['icon'] ?? 'fa-solid fa-tag',
            ]
        );

        return redirect()->back()->with('success', "Kategori \"{$validated['name']}\" berhasil dijadikan Template Sistem bawaan platform.");
    }

    public function promoteInstitution(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:bank,e_wallet,other',
        ]);

        FinancialInstitution::updateOrCreate(
            ['name' => $validated['name']],
            [
                'type' => $validated['type'],
                'status' => 'active',
            ]
        );

        return redirect()->back()->with('success', "Lembaga Keuangan \"{$validated['name']}\" berhasil dijadikan Master Platform.");
    }

    public function storeInstitution(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:bank,e_wallet,other',
            'status' => 'required|in:active,inactive',
        ]);

        FinancialInstitution::create($validated);

        return redirect()->back()->with('success', 'Master Lembaga Keuangan berhasil ditambahkan.');
    }

    public function updateInstitution(Request $request, FinancialInstitution $institution)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:bank,e_wallet,other',
            'status' => 'required|in:active,inactive',
        ]);

        $institution->update($validated);

        return redirect()->back()->with('success', 'Master Lembaga Keuangan berhasil diperbarui.');
    }

    public function destroyInstitution(FinancialInstitution $institution)
    {
        $institution->delete();

        return redirect()->back()->with('success', 'Master Lembaga Keuangan berhasil dihapus.');
    }

    public function storeCategoryTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create([
            'user_id' => null,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'icon' => $validated['icon'] ?? 'fa-solid fa-tag',
            'is_system' => true,
        ]);

        return redirect()->back()->with('success', 'Template Kategori Sistem berhasil ditambahkan.');
    }

    public function destroyCategoryTemplate(Category $category)
    {
        if (! $category->is_system) {
            abort(403);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Template Kategori Sistem berhasil dihapus.');
    }
}
