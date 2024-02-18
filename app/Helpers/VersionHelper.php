<?php

namespace App\Helpers;

use Exception;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Unauthenticated;

#[Unauthenticated]
#[Group('Version', 'System Version')]
class VersionHelper
{

    public static function getCurrentTemplateVersion()
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['template'])) {
            return $data['version']['template'];
        }

        return 'N/A';
    }

    public static function getCurrentProjectVersion()
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['project'])) {
            return $data['version']['project'];
        }

        return 'N/A';
    }

    public static function isDevVersion()
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['dev'] ?? null;
    }

    public static function getRemoteTemplateVersion()
    {
        if (config('app.env') == 'testing') return true;
        if (setting('template_version_url') == null) return true;

        try {
            $url = setting('template_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['template'] == null) return true;

            return $data['version']['template'];
        } catch (Exception $e) {
            return true;
        }
    }

    public static function getRemoteProjectVersion()
    {
        if (config('app.env') == 'testing') return true;
        if (setting('project_version_url') == null) return true;

        try {
            $url = setting('project_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['project'] == null) return true;

            return $data['version']['project'];
        } catch (Exception $e) {
            return true;
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
