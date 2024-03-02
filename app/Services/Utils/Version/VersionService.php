<?php

namespace App\Services\Utils\Version;

use Exception;

class VersionService
{
    /**
     * Retrieves the current version of the template.
     *
     * @return string The current version of the template. If the version is not available, returns 'N/A'.
     */
    public function getCurrentTemplateVersion(): string
    {
        if (config('app.env') == 'testing') {
            return true;
        }
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['template'])) {
            return $data['version']['template'];
        }

        return 'N/A';
    }

    /**
     * Retrieves the current project version.
     *
     * @return string The current project version if available, otherwise 'N/A'.
     */
    public function getCurrentProjectVersion(): string
    {
        if (config('app.env') == 'testing') {
            return true;
        }
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['version']['project'])) {
            return $data['version']['project'];
        }

        return 'N/A';
    }

    /**
     * Determines if the current version is a development version.
     *
     * @return bool Returns true if the current version is a development version, false otherwise.
     */
    public function isDevVersion(): bool
    {
        if (config('app.env') == 'testing') {
            return true;
        }
        $file = base_path('version.json');
        $data = json_decode(file_get_contents($file), true);

        return $data['version']['dev'] ?? false;
    }

    /**
     * Retrieves the remote template version.
     *
     * Returns the version of the remote template if it is available. If the application environment is set to 'testing'
     * or the URL for the template version is not configured, it will return a boolean value of `true`.
     *
     * @return string|bool The version of the remote template if available, or `true` if not.
     */
    public function getRemoteTemplateVersion(): string|bool
    {
        if (config('app.env') == 'testing') {
            return true;
        }
        if (setting('template_version_url') == null) {
            return true;
        }

        try {
            $url = setting('template_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['template'] == null) {
                return true;
            }

            return $data['version']['template'];
        } catch (Exception) {
            return true;
        }
    }

    /**
     * Retrieves the version of the remote project.
     *
     * This method makes a request to the remote project version URL and retrieves
     * the version of the project. It will return the project version as a string
     * if a valid version value is obtained. If the application environment is set
     * to 'testing', it will always return a boolean true.
     *
     * @return string|bool The version of the remote project as a string if available,
     *                     otherwise a boolean true if the application environment is 'testing'
     *                     or if the project version URL is not set or unavailable.
     */
    public function getRemoteProjectVersion(): string|bool
    {
        if (config('app.env') == 'testing') {
            return true;
        }
        if (setting('project_version_url') == null) {
            return true;
        }

        try {
            $url = setting('project_version_url');
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['project'] == null) {
                return true;
            }

            return $data['version']['project'];
        } catch (Exception) {
            return true;
        }
    }

    /**
     * Check if the current version of the template is up to date with the remote version.
     *
     * @return bool Returns true if the template is up to date, false otherwise.
     */
    public function isTemplateUpToDate(): bool
    {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') {
            return true;
        }

        return $currentVersion == $remoteVersion;
    }

    /**
     * Determines whether the current project version is up to date.
     *
     * @return bool Returns true if the project is up to date, false otherwise.
     */
    public function isProjectUpToDate(): bool
    {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') {
            return true;
        }

        return $currentVersion == $remoteVersion;
    }
}
