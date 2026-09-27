<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'admin_fee')) {
                $table->decimal('admin_fee', 15, 2)->default(0)->after('amount');
            }
        });

        Schema::table('budgets', function (Blueprint $table) {
            if (!Schema::hasColumn('budgets', 'allocation_type')) {
                $table->string('allocation_type')->default('nominal')->after('amount');
            }
            if (!Schema::hasColumn('budgets', 'percentage')) {
                $table->decimal('percentage', 5, 2)->nullable()->after('allocation_type');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_system');
            }
        });

        Schema::table('accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('accounts', 'account_category')) {
                $table->string('account_category')->default('regular')->after('type'); // regular, savings
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'admin_fee')) {
                $table->dropColumn('admin_fee');
            }
        });

        Schema::table('budgets', function (Blueprint $table) {
            if (Schema::hasColumn('budgets', 'allocation_type')) {
                $table->dropColumn('allocation_type');
            }
            if (Schema::hasColumn('budgets', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('accounts', function (Blueprint $table) {
            if (Schema::hasColumn('accounts', 'account_category')) {
                $table->dropColumn('account_category');
            }
        });
    }
};
