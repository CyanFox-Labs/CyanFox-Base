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

        if (isset($data['version']['template'])) {
            return $data['version']['template'];
        }

        return 'N/A';
    }

    public static function getCurrentProjectVersion()
    {
        if (env('APP_ENV') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['project'])) {
            return $data['version']['project'];
        }

        return 'N/A';
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

            if ($data['version']['template'] == null) return true;

            return $data['version']['template'];
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

            if ($data['version']['project'] == null) return true;

            return $data['version']['project'];
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function isTemplateUpToDate()
    {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') return true;

        return $currentVersion == $remoteVersion;
    }

    public static function isProjectUpToDate()
    {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        if ($currentVersion == null || $remoteVersion == null
        || $currentVersion == 'N/A' || $remoteVersion == 'N/A') return true;

        return $currentVersion == $remoteVersion;
    }
}
