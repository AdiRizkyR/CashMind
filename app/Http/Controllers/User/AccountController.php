<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\FinancialInstitution;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $accounts = $user->accounts()->with('institution')->get();
        $institutions = FinancialInstitution::where('status', 'active')->get();

        return view('user.accounts', compact('accounts', 'institutions'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:cash,bank,e_wallet,other',
            'institution_id' => 'nullable|exists:financial_institutions,id',
            'initial_balance' => 'required|numeric|min:0',
        ]);

        $user->accounts()->create($validated);

        return redirect()->back()->with('success', 'Akun keuangan berhasil ditambahkan.');
    }

    public function update(Request $request, Account $account)
    {
        $user = $request->user();

        if ($account->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:cash,bank,e_wallet,other',
            'institution_id' => 'nullable|exists:financial_institutions,id',
            'initial_balance' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $account->update($validated);

        return redirect()->back()->with('success', 'Akun keuangan berhasil diperbarui.');
    }

    public function destroy(Request $request, Account $account)
    {
        $user = $request->user();

        if ($account->user_id !== $user->id) {
            abort(403);
        }

        if ($account->transactions()->count() > 0) {
            return redirect()->back()->withErrors(['account' => 'Akun yang memiliki transaksi tidak dapat dihapus. Anda dapat menonaktifkannya.']);
        }

        $account->delete();

        return redirect()->back()->with('success', 'Akun keuangan berhasil dihapus.');
    }
}
