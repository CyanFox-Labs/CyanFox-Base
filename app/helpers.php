<?php

use App\Facades\Utils\SettingsManager;
use App\Services\Modules\ModuleService;
use App\Services\Utils\SettingsService;
use App\Services\Utils\UnsplashService;
use App\Services\Utils\VersionService;
use App\Services\Utils\ViewIntegrationService;
use Modules\AuthModule\Services\Users\UserService;

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

if (!function_exists('viewIntegration')) {
    function viewIntegration(): ViewIntegrationService
    {
        return app(ViewIntegrationService::class);
    }
}

if (!function_exists('user')) {
    function user(): UserService
    {
        return new UserService;
    }
}
