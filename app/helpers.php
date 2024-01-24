<?php

use App\Helpers\ActivityLogHelper;
use App\Helpers\VersionHelper;
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

if (!function_exists('get_version')) {

    /**
     * Get the current version of the application.
     */
    function get_version($type = 'template')
    {
        return match ($type) {
            'template' => VersionHelper::getCurrentTemplateVersion(),
            'project' => VersionHelper::getCurrentProjectVersion(),
            'remote_template' => VersionHelper::getRemoteTemplateVersion(),
            'remote_project' => VersionHelper::getRemoteProjectVersion(),
            default => null,
        };
    }
}

if (!function_exists('activity')) {

    /**
     * Log an activity to the database.
     */
    function activity()
    {
        return new ActivityLogHelper();
    }
}
