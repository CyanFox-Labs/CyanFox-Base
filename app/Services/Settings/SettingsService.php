<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Exception;

class SettingsService
{
    public function getSetting(string $key, bool $isEncrypted = false): ?string
    {
        try {
            $setting = Setting::where('key', $key)->first();

            if ($setting == null) {
                $setting = $this->setSetting($key, $isEncrypted);
            }

            if ($isEncrypted) {
                try {
                    return decrypt($setting->value);
                } catch (Exception) {
                    return $setting->value;
                }
            }

            return match ($setting->value) {
                'true', 1 => true,
                'false', 0 => false,
                default => $setting->value,
            };
        } catch (Exception) {
            return null;
        }
    }

    public function setSetting(string $key, ?string $value = null, bool $isEncrypted = false): Setting
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting == null) {
            $setting = new Setting;
            $setting->key = $key;
            if ($value != null) {
                $setting->value = ($isEncrypted) ? encrypt($value) : $value;
            } else {
                $setting->value = ($isEncrypted) ? encrypt(env(strtoupper($key))) : env(strtoupper($key));
            }
            $setting->save();
        }

        return $setting;
    }

    public function updateSetting(string $key, ?string $value, bool $isEncrypted = false): Setting
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting != null) {
            $setting->value = ($isEncrypted) ? encrypt($value) : $value;
            $setting->save();
        }

        return $setting;
    }

    public function updateSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->updateSetting($key, $value);
        }
    }

    public function deleteSetting(string $key): bool
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting != null) {
            return $setting->delete();
        }

        return false;
    }
}
