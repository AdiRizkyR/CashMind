<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\FinancialInstitution;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
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
            ['name' => 'Bank Jago', 'type' => 'bank'],
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

        // 2. Seed Default System Category Templates
        $systemCategories = [
            // Income
            ['name' => 'Gaji Pokok', 'type' => 'income', 'icon' => 'fa-solid fa-money-bill-wave'],
            ['name' => 'Side Job / Freelance', 'type' => 'income', 'icon' => 'fa-solid fa-laptop-code'],
            ['name' => 'Bonus & THR', 'type' => 'income', 'icon' => 'fa-solid fa-gift'],
            ['name' => 'Investasi & Dividen', 'type' => 'income', 'icon' => 'fa-solid fa-chart-line'],
            ['name' => 'Saldo Awal', 'type' => 'income', 'icon' => 'fa-solid fa-[#10B981]'],

            // Expense
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'icon' => 'fa-solid fa-utensils'],
            ['name' => 'Transportasi & Bensin', 'type' => 'expense', 'icon' => 'fa-solid fa-car'],
            ['name' => 'Tagihan & Utilitas', 'type' => 'expense', 'icon' => 'fa-solid fa-file-invoice-dollar'],
            ['name' => 'Belanja Harian', 'type' => 'expense', 'icon' => 'fa-solid fa-cart-shopping'],
            ['name' => 'Hiburan & Gaya Hidup', 'type' => 'expense', 'icon' => 'fa-solid fa-gamepad'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => 'fa-solid fa-heart-pulse'],
            ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => 'fa-solid fa-graduation-cap'],
            ['name' => 'Biaya Admin / Bank Fee', 'type' => 'expense', 'icon' => 'fa-solid fa-building-columns'],
            ['name' => 'Lain-lain', 'type' => 'expense', 'icon' => 'fa-solid fa-ellipsis'],
        ];

        foreach ($systemCategories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name'], 'is_system' => true],
                ['type' => $cat['type'], 'icon' => $cat['icon'], 'user_id' => null, 'is_active' => true]
            );
        }

        // 3. Seed Seeders Data for user@cashmind.id and demouser@cashmind.id
        $usersToSeed = User::whereIn('email', ['user@cashmind.id', 'demouser@cashmind.id'])->get();

        foreach ($usersToSeed as $user) {
            $bcaInst = FinancialInstitution::where('name', 'Bank BCA')->first();
            $mandiriInst = FinancialInstitution::where('name', 'Bank Mandiri')->first();
            $gopayInst = FinancialInstitution::where('name', 'GoPay')->first();

            // User Profile Settings
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'monthly_income' => 8500000,
                    'payday_date' => 25,
                    'payday_frequency' => 'monthly',
                    'financial_goal_type' => 'balanced',
                    'dependents_count' => 1,
                    'risk_profile' => 'moderate',
                    'recommendation_frequency' => 'month_start',
                    'auto_apply_recommendation' => false,
                ]
            );

            // Accounts
            $cashAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Cash Tunai Dompet'],
                ['type' => 'cash', 'account_category' => 'regular', 'initial_balance' => 850000, 'is_active' => true]
            );

            $bcaAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Rekening BCA Utama'],
                ['type' => 'bank', 'account_category' => 'regular', 'institution_id' => $bcaInst?->id, 'initial_balance' => 6500000, 'is_active' => true]
            );

            $mandiriSavings = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Rekening Tabungan Mandiri'],
                ['type' => 'bank', 'account_category' => 'savings', 'institution_id' => $mandiriInst?->id, 'initial_balance' => 4500000, 'is_active' => true]
            );

            $gopayAcc = Account::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Dompet GoPay'],
                ['type' => 'e_wallet', 'account_category' => 'regular', 'institution_id' => $gopayInst?->id, 'initial_balance' => 420000, 'is_active' => true]
            );

            // User Custom Categories
            $foodCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Makanan & Kuliner'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-utensils', 'is_system' => false, 'is_active' => true]
            );

            $transportCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Transportasi & Bensin'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-car', 'is_system' => false, 'is_active' => true]
            );

            $billsCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Tagihan & PLN'],
                ['type' => 'expense', 'icon' => 'fa-solid fa-file-invoice-dollar', 'is_system' => false, 'is_active' => true]
            );

            $salaryCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'Gaji Bulanan'],
                ['type' => 'income', 'icon' => 'fa-solid fa-wallet', 'is_system' => false, 'is_active' => true]
            );

            $adminFeeCat = Category::where('name', 'like', '%Admin%')->first();

            // Seed Demo Transactions
            $now = Carbon::now();

            // Income Salary
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Transfer Gaji Bulanan Perusahaan'],
                [
                    'account_id' => $bcaAcc->id,
                    'category_id' => $salaryCat->id,
                    'type' => 'income',
                    'amount' => 8500000,
                    'transaction_date' => $now->copy()->startOfMonth()->addDays(1),
                    'note' => 'Gaji pokok bulanan',
                ]
            );

            // Expenses
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Belanja Kebutuhan Dapur & Bahan Makanan'],
                [
                    'account_id' => $gopayAcc->id,
                    'category_id' => $foodCat->id,
                    'type' => 'expense',
                    'amount' => 680000,
                    'transaction_date' => $now->copy()->subDays(3),
                ]
            );

            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Pembayaran Tagihan Listrik & WiFi IndiHome'],
                [
                    'account_id' => $bcaAcc->id,
                    'category_id' => $billsCat->id,
                    'type' => 'expense',
                    'amount' => 520000,
                    'transaction_date' => $now->copy()->subDays(6),
                ]
            );

            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Isi Bensin Pertamax Mobil'],
                [
                    'account_id' => $cashAcc->id,
                    'category_id' => $transportCat->id,
                    'type' => 'expense',
                    'amount' => 250000,
                    'transaction_date' => $now->copy()->subDays(4),
                ]
            );

            // Transfer Internal & Admin Fee
            $transferTx = Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => 'Transfer Pokok Menabung ke Rekening Mandiri'],
                [
                    'account_id' => $bcaAcc->id,
                    'destination_account_id' => $mandiriSavings->id,
                    'category_id' => null,
                    'type' => 'transfer',
                    'amount' => 2000000,
                    'admin_fee' => 6500,
                    'transaction_date' => $now->copy()->subDays(5),
                    'note' => 'Pokok tabungan darurat bulanan',
                ]
            );

            if ($adminFeeCat) {
                Transaction::updateOrCreate(
                    ['user_id' => $user->id, 'transfer_reference_id' => (string) $transferTx->id],
                    [
                        'account_id' => $bcaAcc->id,
                        'category_id' => $adminFeeCat->id,
                        'type' => 'expense',
                        'amount' => 6500,
                        'transaction_date' => $now->copy()->subDays(5),
                        'description' => 'Biaya Admin Transfer (Transfer Pokok Menabung ke Rekening Mandiri)',
                        'note' => 'Otomatis dicatat dari transfer #'.$transferTx->id,
                    ]
                );
            }

            // Seed Budgets (Food, Transport, Bills)
            Budget::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $foodCat->id, 'period_month' => $now->month, 'period_year' => $now->year],
                ['amount' => 2000000, 'allocation_type' => 'nominal']
            );

            Budget::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $transportCat->id, 'period_month' => $now->month, 'period_year' => $now->year],
                ['amount' => 1000000, 'allocation_type' => 'nominal']
            );

            Budget::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $billsCat->id, 'period_month' => $now->month, 'period_year' => $now->year],
                ['amount' => 800000, 'allocation_type' => 'nominal']
            );
        }
    }
}
