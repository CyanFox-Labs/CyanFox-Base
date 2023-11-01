<?php

namespace App\Http\Controllers;

class VersionController extends Controller
{

    public static function getCurrentTemplateVersion() {
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['template'] ?? null;
    }

    public static function getCurrentProjectVersion() {
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['project'] ?? null;
    }

    public static function getRemoteTemplateVersion() {
        $url = env('TEMPLATE_VERSION_URL');
        $data = json_decode(file_get_contents($url), true);

        return $data['version']['template'] ?? null;
    }

    public static function getRemoteProjectVersion() {
        $url = env('PROJECT_VERSION_URL');
        $data = json_decode(file_get_contents($url), true);

        return $data['version']['project'] ?? null;
    }

    public static function isTemplateUpToDate() {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        return $currentVersion == $remoteVersion;
    }

    public static function isProjectUpToDate() {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        return $currentVersion == $remoteVersion;
    }
}
