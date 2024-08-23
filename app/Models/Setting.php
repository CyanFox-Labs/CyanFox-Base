<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    public $table = 'settings';

    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
        'is_locked',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($setting) {
            if ($setting->isDirty('value') && $setting->is_locked) {
                Log::warning('Attempted to update locked setting: ' . $setting->key);

                return false;
            }

            return true;
        });
    }
}
