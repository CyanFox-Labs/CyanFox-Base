<?php

namespace App\Services\Utils;

use App\Services\Utils\Unsplash\UnsplashService;
use App\Services\Utils\Version\VersionService;

class UtilsService
{
    /**
     * Returns an instance of UnsplashService.
     *
     * @return UnsplashService An instance of the UnsplashService class.
     */
    public function getUnsplashManager(): UnsplashService
    {
        return new UnsplashService;
    }

    /**
     * Retrieves the version manager.
     *
     * @return VersionService The version manager instance.
     */
    public function getVersionManager(): VersionService
    {
        return new VersionService;
    }
}
