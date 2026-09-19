<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialInstitution extends Model
{
    protected $fillable = [
        'name',
        'type',
        'logo',
        'status',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'institution_id');
    }
}
