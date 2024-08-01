<?php

namespace App\Facades\Utils;

use App\Models\Setting;
use App\Services\Utils\SettingsService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getSetting(string $key, bool $isEncrypted = false)
 * @method static Setting setSetting(string $key, string $value = null, bool $isEncrypted = false, bool $updateIfExists = false)
 * @method static Setting updateSetting(string $key, string $value = null, bool $isEncrypted = false)
 * @method static void updateSettings(array $settings)
 * @method static Setting deleteSetting(string $key)
 */
class SettingsManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsService::class;
    }
}
