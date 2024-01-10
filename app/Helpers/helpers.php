<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {

    /**
     * Get a specific setting from the database.
     * If the setting does not exist, it will use the .env value.
     */
    function get_setting($identifier, $key)
    {
        $setting = Setting::where('identifier', $identifier)->where('key', $key)->first();

        if ($setting == null) {
            return env(strtoupper(str_replace('-', '_', $identifier))
                . '_' . strtoupper(str_replace('-', '_', $key)));
        }

        return $setting->value;
    }
}
