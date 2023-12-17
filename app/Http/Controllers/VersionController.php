<?php

namespace App\Http\Controllers;

use Exception;

class VersionController extends Controller
{

    public static function getCurrentTemplateVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['template'] ?? null;
    }

    public static function getCurrentProjectVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['project'] ?? null;
    }

    public static function isDevVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['dev'] ?? null;
    }

    public static function getRemoteTemplateVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        if (env('TEMPLATE_VERSION_URL') == null) return true;

        try {
            $url = env('TEMPLATE_VERSION_URL');
            $data = json_decode(file_get_contents($url), true);

            return $data['version']['template'] ?? null;
        } catch (Exception $e) {
            return true;
        }
    }

    public static function getRemoteProjectVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        if (env('PROJECT_VERSION_URL') == null) return true;

        try {
            $url = env('PROJECT_VERSION_URL');
            $data = json_decode(file_get_contents($url), true);

            return $data['version']['project'] ?? null;
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function isTemplateUpToDate()
    {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        return $currentVersion == $remoteVersion;
    }

    public static function isProjectUpToDate()
    {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        return $currentVersion == $remoteVersion;
    }
}
