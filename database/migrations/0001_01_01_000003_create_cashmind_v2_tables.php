<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for CashMind v2 core system.
     */
    public function up(): void
    {
        // 1. Master Financial Institutions (Banks & E-Wallets)
        Schema::create('financial_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('bank'); // bank, e_wallet, other
            $table->string('logo')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });

        // 2. User Financial Accounts
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('cash'); // cash, bank, e_wallet, other
            $table->foreignId('institution_id')->nullable()->constrained('financial_institutions')->nullOnDelete();
            $table->decimal('initial_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Categories (System Templates & User Custom Categories)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // null = system template
            $table->string('name');
            $table->string('type')->default('expense'); // income, expense
            $table->string('icon')->default('fa-solid fa-tag');
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });

        // 4. Unified Transactions (Income, Expense, Transfer, Adjustment)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('destination_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('type'); // income, expense, transfer, adjustment
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->string('transfer_reference_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Category Budgets
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->integer('period_month');
            $table->integer('period_year');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });

        // 6. Financial Goals
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('target_amount', 15, 2);
            $table->date('target_date')->nullable();
            $table->string('status')->default('in_progress'); // in_progress, completed, cancelled
            $table->timestamps();
        });

        // 7. Goal Contributions
        Schema::create('goal_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->date('contribution_date');
            $table->string('note')->nullable();
            $table->timestamps();
        });

        // 8. Account Reconciliations
        Schema::create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->decimal('system_balance', 15, 2);
            $table->decimal('actual_balance', 15, 2);
            $table->decimal('difference', 15, 2);
            $table->timestamp('reconciled_at');
            $table->string('note')->nullable();
            $table->timestamps();
        });

        // 9. Feature Flags
        Schema::create('feature_flags', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        // 10. Platform Security Logs (No financial data)
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event'); // LOGIN_SUCCESS, LOGIN_FAILED, PASSWORD_CHANGED, ACCOUNT_SUSPENDED, etc.
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 11. User Category Toggles (User preference for system category templates)
        Schema::create('user_category_toggles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['user_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('user_category_toggles');
        Schema::dropIfExists('security_logs');
        Schema::dropIfExists('feature_flags');
        Schema::dropIfExists('reconciliations');
        Schema::dropIfExists('goal_contributions');
        Schema::dropIfExists('goals');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('financial_institutions');

        Schema::enableForeignKeyConstraints();
    }
};
