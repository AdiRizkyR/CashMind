<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'period_month',
        'period_year',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'period_month' => 'integer',
        'period_year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Calculate spent amount in this budget's category and period.
     */
    public function getSpentAttribute(): float
    {
        return (float) Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $this->period_month)
            ->whereYear('transaction_date', $this->period_year)
            ->sum('amount');
    }

    public function getPercentageAttribute(): float
    {
        if ($this->amount <= 0) {
            return 0;
        }

        return min(100, round(($this->spent / $this->amount) * 100, 1));
    }

    public function getStatusAttribute(): string
    {
        if ($this->amount <= 0) {
            return 'Safe';
        }
        $ratio = ($this->spent / $this->amount) * 100;
        if ($ratio < 80) {
            return 'Safe';
        } elseif ($ratio <= 100) {
            return 'Warning';
        } else {
            return 'Exceeded';
        }
    }
}
