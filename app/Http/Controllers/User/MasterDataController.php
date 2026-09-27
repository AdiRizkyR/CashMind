<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\FinancialInstitution;
use App\Models\UserCategoryToggle;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $tab = $request->get('tab', 'income_categories'); // income_categories, expense_categories, ewallets, banks, cash

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

        // Accounts split by type
        $accounts = $user->accounts()->with('institution')->get();
        $cashAccounts = $accounts->where('type', 'cash');
        $bankAccounts = $accounts->where('type', 'bank');
        $ewalletAccounts = $accounts->where('type', 'e_wallet');
        $savingsAccounts = $accounts->where('account_category', 'savings');

        $institutions = FinancialInstitution::where('status', 'active')->get();

        return view('user.master_data', compact(
            'tab',
            'userExpenseCategories',
            'userIncomeCategories',
            'systemExpenseCategories',
            'systemIncomeCategories',
            'accounts',
            'cashAccounts',
            'bankAccounts',
            'ewalletAccounts',
            'savingsAccounts',
            'institutions'
        ));
    }
}
