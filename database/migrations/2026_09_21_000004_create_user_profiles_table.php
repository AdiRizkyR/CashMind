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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('monthly_income', 15, 2)->default(0);
            $table->integer('payday_date')->default(25); // 1-31
            $table->string('payday_frequency')->default('monthly'); // monthly, biweekly, weekly
            $table->string('financial_goal_type')->default('balanced'); // saving_focused, balanced, debt_reduction, frugal
            $table->integer('dependents_count')->default(0);
            $table->string('risk_profile')->default('moderate'); // conservative, moderate, aggressive
            $table->string('recommendation_frequency')->default('month_start'); // month_start, payday, weekly, manual
            $table->boolean('auto_apply_recommendation')->default(false);
            $table->timestamp('last_recommendation_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
