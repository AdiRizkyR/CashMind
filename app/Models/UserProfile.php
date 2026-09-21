<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'monthly_income',
        'payday_date',
        'payday_frequency',
        'financial_goal_type',
        'dependents_count',
        'risk_profile',
        'recommendation_frequency',
        'auto_apply_recommendation',
        'last_recommendation_at',
    ];

    protected function casts(): array
    {
        return [
            'monthly_income' => 'decimal:2',
            'payday_date' => 'integer',
            'dependents_count' => 'integer',
            'auto_apply_recommendation' => 'boolean',
            'last_recommendation_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
