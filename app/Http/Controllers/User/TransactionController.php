<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\UserCategoryToggle;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->transactions()->with(['account', 'destinationAccount', 'category']);

        // Filters
        if ($request->filled('type') && in_array($request->type, ['income', 'expense', 'transfer', 'adjustment'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('account_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('account_id', $request->account_id)
                    ->orWhere('destination_account_id', $request->account_id);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $accounts = $user->accounts()->where('is_active', true)->get();
        $disabledSystemCatIds = UserCategoryToggle::where('user_id', $user->id)
            ->where('is_active', false)
            ->pluck('category_id')
            ->toArray();
        $categories = $user->categories()->get()->concat(
            Category::where('is_system', true)
                ->whereNotIn('id', $disabledSystemCatIds)
                ->get()
        );

        return view('user.transactions', compact('transactions', 'accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer,adjustment',
            'amount' => 'required|numeric|min:1',
            'account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|required_if:type,transfer|exists:accounts,id|different:account_id',
            'category_id' => 'nullable|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        // Security check account belongs to user
        $user->accounts()->findOrFail($validated['account_id']);
        if (! empty($validated['destination_account_id'])) {
            $user->accounts()->findOrFail($validated['destination_account_id']);
        }

        $user->transactions()->create($validated);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $user = $request->user();

        // Ownership check
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer,adjustment',
            'amount' => 'required|numeric|min:1',
            'account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|required_if:type,transfer|exists:accounts,id|different:account_id',
            'category_id' => 'nullable|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $user->accounts()->findOrFail($validated['account_id']);
        if (! empty($validated['destination_account_id'])) {
            $user->accounts()->findOrFail($validated['destination_account_id']);
        }

        $transaction->update($validated);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $user = $request->user();

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
