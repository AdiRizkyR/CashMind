<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'institution_id',
        'initial_balance',
        'is_active',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(FinancialInstitution::class, 'institution_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function incomingTransfers(): HasMany
    {
        return $this->hasMany(Transaction::class, 'destination_account_id');
    }

    /**
     * Calculate current balance based on initial_balance + income - expense + incoming transfer - outgoing transfer + adjustment.
     */
    public function getBalanceAttribute(): float
    {
        $initial = (float) $this->initial_balance;

        $income = (float) $this->transactions()->where('type', 'income')->sum('amount');
        $expense = (float) $this->transactions()->where('type', 'expense')->sum('amount');

        $outgoingTransfer = (float) $this->transactions()->where('type', 'transfer')->sum('amount');
        $incomingTransfer = (float) $this->incomingTransfers()->where('type', 'transfer')->sum('amount');

        $adjustments = (float) $this->transactions()->where('type', 'adjustment')->sum('amount');

        return $initial + $income - $expense - $outgoingTransfer + $incomingTransfer + $adjustments;
    }
}
