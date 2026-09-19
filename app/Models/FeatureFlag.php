<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public static function isEnabled(string $key, bool $default = true): bool
    {
        $flag = static::where('key', $key)->first();

        return $flag ? $flag->enabled : $default;
    }
}
