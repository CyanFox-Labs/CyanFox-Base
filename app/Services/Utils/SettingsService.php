<?php

namespace App\Services\Utils;

use App\Models\Setting;
use Exception;

class SettingsService
{
    /**
     * Retrieves the value of a setting based on the provided key.
     * If the setting does not exist, it will be created with the given key and encryption flag.
     *
     * @param  string  $key  The key of the setting.
     * @param  bool  $isEncrypted  Indicates whether the setting value is encrypted. Defaults to false.
     * @return string|null The value of the setting. If $isEncrypted is true and decryption fails, the raw encrypted value is returned.
     */
    public function getSetting(string $key, bool $isEncrypted = false): ?string
    {
        try {
            $setting = Setting::where('key', $key)->first();

            if ($setting == null) {
                $setting = $this->setSetting($key, isEncrypted: $isEncrypted);
            }

            if ($isEncrypted) {
                try {
                    return decrypt($setting->value);
                } catch (Exception) {
                    return $setting->value;
                }
            }

            if ($setting->value == null) {
                return config($key);
            }

            return match ($setting->value) {
                'true', 1 => true,
                'false', 0 => false,
                default => $setting->value,
            };
        } catch (Exception) {
            return config($key);
        }
    }

    /**
     * Set the value of a setting by key, encrypting if necessary.
     *
     * @param  string  $key  The key of the setting.
     * @param  string|null  $value  The value of the setting. Defaults to null.
     * @param  bool  $isEncrypted  Determines if the value should be encrypted. Defaults to false.
     * @return Setting The newly created or updated Setting object.
     */
    public function setSetting(string $key, ?string $value = null, bool $isEncrypted = false): Setting
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting == null) {
            $setting = new Setting;
            $setting->key = $key;
            if ($value != null) {
                $setting->value = ($isEncrypted) ? encrypt($value) : $value;
            } else {
                $setting->value = ($isEncrypted) ? encrypt(config($key)) : config($key);
            }
            $setting->save();
        }

        return $setting;
    }

    /**
     * Updates a specific setting with the given key and value.
     *
     * @param  string  $key  The key of the setting to be updated.
     * @param  string|null  $value  The new value for the setting. If null, the value will not be updated.
     * @param  bool  $isEncrypted  Determines whether the value needs to be encrypted before saving.
     * @return Setting The updated Setting object, or null if the setting with the given key does not exist.
     */
    public function updateSetting(string $key, ?string $value, bool $isEncrypted = false): Setting
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting != null) {
            $setting->value = ($isEncrypted) ? encrypt($value) : $value;
            $setting->save();
        } else {
            $setting = $this->setSetting($key, $value, $isEncrypted);
        }

        return $setting;
    }

    /**
     * Updates the settings by calling the updateSetting method for each key-value pair in the given settings array.
     *
     * @param  array  $settings  An array of key-value pairs representing the settings to update.
     */
    public function updateSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->updateSetting($key, $value);
        }
    }

    /**
     * Deletes a setting from the database based on the provided key.
     *
     * @param  string  $key  The key of the setting to be deleted.
     * @return bool True if the setting is successfully deleted, otherwise false.
     */
    public function deleteSetting(string $key): bool
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting != null) {
            return $setting->delete();
        }

        return false;
    }
}
