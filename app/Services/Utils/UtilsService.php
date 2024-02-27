<?php

namespace App\Services\Utils;

use App\Services\Utils\Unsplash\UnsplashService;
use App\Services\Utils\Version\VersionService;

class UtilsService
{
    public function getUnsplashManager(): UnsplashService
    {
        return new UnsplashService;
    }

    public function getVersionManager(): VersionService
    {
        return new VersionService;
    }
}
