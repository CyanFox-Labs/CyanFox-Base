<?php

use App\Facades\SettingsManager;
use App\Services\Activity\ActivityLogService;
use App\Services\Groups\GroupService;
use App\Services\Modules\ModuleService;
use App\Services\Settings\SettingsService;
use App\Services\Users\UserService;
use App\Services\Utils\Unsplash\UnsplashService;
use App\Services\Utils\UtilsService;
use App\Services\Utils\Version\VersionService;

if (!function_exists('version')) {
    function version(): VersionService
    {
        return new VersionService;
    }
}

if (!function_exists('unsplash')) {
    function unsplash(): UnsplashService
    {
        return new UnsplashService;
    }
}

if (!function_exists('utils')) {
    function utils(): UtilsService
    {
        return new UtilsService;
    }
}

if (!function_exists('activity')) {
    function activity(): ActivityLogService
    {
        return new ActivityLogService;
    }
}

if (!function_exists('group')) {
    function group(): GroupService
    {
        return new GroupService;
    }
}

if (!function_exists('module')) {
    function module(): ModuleService
    {
        return new ModuleService;
    }
}

if (!function_exists('setting')) {
    function setting($key = null, $isEncrypted = false): null|string|SettingsService
    {
        if ($key == null) {
            return new SettingsService;
        }

        return SettingsManager::getSetting($key, $isEncrypted);
    }
}

if (!function_exists('user')) {
    function user(): UserService
    {
        return new UserService;
    }
}
