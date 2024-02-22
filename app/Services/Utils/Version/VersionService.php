<?php

namespace App\Services\Utils\Version;

use Exception;

class VersionService
{

    public function getCurrentTemplateVersion(): string
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['template'])) {
            return $data['version']['template'];
        }

        return 'N/A';
    }

    public function getCurrentProjectVersion(): string
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['project'])) {
            return $data['version']['project'];
        }

        return 'N/A';
    }

    public function isDevVersion(): bool
    {
        if (config('app.env') == 'testing') return true;
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['dev'] ?? false;
    }

    public function getRemoteTemplateVersion(): string | bool
    {
        if (config('app.env') == 'testing') return true;
        if (setting('template_version_url') == null) return true;

        try {
            $url = setting('template_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['template'] == null) return true;

            return $data['version']['template'];
        } catch (Exception) {
            return true;
        }
    }

    public function getRemoteProjectVersion(): string | bool
    {
        if (config('app.env') == 'testing') return true;
        if (setting('project_version_url') == null) return true;

        try {
            $url = setting('project_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['project'] == null) return true;

            return $data['version']['project'];
        } catch (Exception) {
            return true;
        }
    }

    public function isTemplateUpToDate(): bool
    {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') return true;

        return $currentVersion == $remoteVersion;
    }

    public function isProjectUpToDate(): bool
    {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') return true;

        return $currentVersion == $remoteVersion;
    }

}
