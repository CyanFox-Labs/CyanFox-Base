<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $table = 'settings';
    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get($key, $isEncrypted)
    {
        try {
            $setting = self::where('key', $key)->first();

            if ($setting == null) {
                $setting = new self();
                $setting->key = $key;
                $setting->save();
            }

            if ($setting->value == null) {
                $setting->value = ($isEncrypted) ? encrypt(env(strtoupper($key))) : env(strtoupper($key));
                $setting->save();
            }

            if ($isEncrypted) {
                return decrypt($setting->value);
            }

            return match ($setting->value) {
                'true', 1 => true,
                'false', 0 => false,
                default => $setting->value,
            };

        } catch
        (\Exception $e) {
            \Log::error($e->getMessage());
            return '';
        }
    }
}
