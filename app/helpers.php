<?php

use App\Models\Setting;

if (!function_exists('setting')) {

    /**
     * Get a specific setting from the database.
     * If the setting does not exist, it will use the .env value.
     */
    function setting($key, $isEncrypted = false, $isConfig = false)
    {
        if (!$isConfig) {
            return Setting::get($key, $isEncrypted);
        }

        return app()->booted(function () use ($key, $isEncrypted) {
            return Setting::get($key, $isEncrypted);
        });
    }
}
