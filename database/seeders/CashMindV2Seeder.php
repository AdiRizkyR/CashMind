<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\FeatureFlag;
use App\Models\FinancialInstitution;
use App\Models\Goal;
use App\Models\GoalContribution;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CashMindV2Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Financial Institutions
        $institutions = [
            ['name' => 'Bank BCA', 'type' => 'bank'],
            ['name' => 'Bank Mandiri', 'type' => 'bank'],
            ['name' => 'Bank BRI', 'type' => 'bank'],
            ['name' => 'Bank BNI', 'type' => 'bank'],
            ['name' => 'GoPay', 'type' => 'e_wallet'],
            ['name' => 'OVO', 'type' => 'e_wallet'],
            ['name' => 'DANA', 'type' => 'e_wallet'],
            ['name' => 'ShopeePay', 'type' => 'e_wallet'],
        ];

        foreach ($institutions as $inst) {
            FinancialInstitution::updateOrCreate(
                ['name' => $inst['name']],
                ['type' => $inst['type'], 'status' => 'active']
            );
        }

        // 2. Seed Default Category Templates (is_system = true, user_id = null)
        $systemCategories = [
            // Income
            ['name' => 'Gaji Pokok', 'type' => 'income', 'icon' => 'fa-solid fa-money-bill-wave'],
            ['name' => 'Side Job / Freelance', 'type' => 'income', 'icon' => 'fa-solid fa-laptop-code'],
            ['name' => 'Bonus & THR', 'type' => 'income', 'icon' => 'fa-solid fa-gift'],
            ['name' => 'Investasi & Dividen', 'type' => 'income', 'icon' => 'fa-solid fa-chart-line'],

            // Expense
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'icon' => 'fa-solid fa-utensils'],
            ['name' => 'Transportasi & Bensin', 'type' => 'expense', 'icon' => 'fa-solid fa-car'],
            ['name' => 'Tagihan & Utilitas', 'type' => 'expense', 'icon' => 'fa-solid fa-file-invoice-dollar'],
            ['name' => 'Belanja Harian', 'type' => 'expense', 'icon' => 'fa-solid fa-cart-shopping'],
            ['name' => 'Hiburan & Hobi', 'type' => 'expense', 'icon' => 'fa-solid fa-gamepad'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => 'fa-solid fa-heart-pulse'],
            ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => 'fa-solid fa-graduation-cap'],
            ['name' => 'Lain-lain', 'type' => 'expense', 'icon' => 'fa-solid fa-ellipsis'],
        ];

        foreach ($systemCategories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name'], 'is_system' => true],
                ['type' => $cat['type'], 'icon' => $cat['icon'], 'user_id' => null]
            );
        }

        // 3. Seed Feature Flags
        $featureFlags = [
            ['key' => 'goals', 'name' => 'Financial Goals', 'description' => 'Target tabungan dan histori kontribusi', 'enabled' => true],
            ['key' => 'budget', 'name' => 'Budget Management', 'description' => 'Anggaran kategori bulanan', 'enabled' => true],
            ['key' => 'reconciliation', 'name' => 'Account Reconciliation', 'description' => 'Audit saldo dan transaksi adjustment', 'enabled' => true],
            ['key' => 'reports_pdf', 'name' => 'PDF & CSV Reports', 'description' => 'Ekspor laporan keuangan pribadi', 'enabled' => true],
            ['key' => 'registration', 'name' => 'User Registration', 'description' => 'Pendaftaran akun baru', 'enabled' => true],
        ];

        foreach ($featureFlags as $flag) {
            FeatureFlag::updateOrCreate(
                ['key' => $flag['key']],
                ['name' => $flag['name'], 'description' => $flag['description'], 'enabled' => $flag['enabled']]
            );
        }

        // 4. Seed Demo User Data (user@cashmind.id)
        $user = User::where('email', 'user@cashmind.id')->first();
        if ($user) {
            // Seed Accounts
            $bcaInst = FinancialInstitution::where('name', 'Bank BCA')->first();
            $gopayInst = FinancialInstitution::where('name', 'GoPay')->first();

            $cashAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Cash (Tunai)'],
                ['type' => 'cash', 'initial_balance' => 750000, 'is_active' => true]
            );

            $bcaAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Rekening BCA'],
                ['type' => 'bank', 'institution_id' => $bcaInst?->id, 'initial_balance' => 5000000, 'is_active' => true]
            );

            $gopayAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Dompet GoPay'],
                ['type' => 'e_wallet', 'institution_id' => $gopayInst?->id, 'initial_balance' => 350000, 'is_active' => true]
            );

            // User Custom Categories
            $foodCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Food & Drink'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-utensils', 'is_system' => false]
            );

            $transportCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Transportation'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-car', 'is_system' => false]
            );

            $billsCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Bills & Utilities'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-file-invoice-dollar', 'is_system' => false]
            );

            $salaryCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Monthly Salary'],
                ['type' => 'income', 'icon' => 'fa-solid fa-wallet', 'is_system' => false]
            );

            // Seed Demo Transactions for Current Month
            $now = Carbon::now();

            // Income
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Gaji Bulan Ini'],
                [
                    'account_id' => $bcaAcc->id,
                    'category_id' => $salaryCat->id,
                    'type' => 'income',
                    'amount' => 7000000,
                    'transaction_date' => $now->copy()->startOfMonth()->addDays(1),
                ]
            );

            // Expenses
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Makan Kopi Starbucks'],
                [
                    'account_id' => $gopayAcc->id,
                    'category_id' => $foodCat->id,
                    'type' => 'expense',
                    'amount' => 55000,
                    'transaction_date' => $now->copy()->subDays(2),
                ]
            );

            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Bayar Tagihan PLN Listrik'],
                [
                    'account_id' => $bcaAcc->id,
                    'category_id' => $billsCat->id,
                    'type' => 'expense',
                    'amount' => 425000,
                    'transaction_date' => $now->copy()->subDays(5),
                ]
            );

            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Isi Bensin Pertamax'],
                [
                    'account_id' => $cashAcc->id,
                    'category_id' => $transportCat->id,
                    'type' => 'expense',
                    'amount' => 150000,
                    'transaction_date' => $now->copy()->subDays(3),
                ]
            );

            // Transfer (BCA to GoPay)
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Top Up GoPay via BCA'],
                [
                    'account_id' => $bcaAcc->id,
                    'destination_account_id' => $gopayAcc->id,
                    'category_id' => null,
                    'type' => 'transfer',
                    'amount' => 500000,
                    'transaction_date' => $now->copy()->subDays(4),
                ]
            );

            // Seed Budget
            Budget::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $foodCat->id, 'period_month' => $now->month, 'period_year' => $now->year],
                ['amount' => 1500000]
            );

            Budget::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $transportCat->id, 'period_month' => $now->month, 'period_year' => $now->year],
                ['amount' => 1000000]
            );

            // Seed Financial Goal
            $goal = Goal::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'MacBook Pro M3'],
                [
                    'target_amount' => 30000000,
                    'target_date' => $now->copy()->addMonths(9),
                    'status' => 'in_progress',
                ]
            );

            GoalContribution::updateOrCreate(
                ['goal_id' => $goal->id, 'user_id' => $user->id, 'note' => 'Setoran Awal Tabungan Laptop'],
                [
                    'amount' => 12500000,
                    'contribution_date' => $now->copy()->subDays(10),
                ]
            );
        }
    }
}
