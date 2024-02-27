<?php

namespace App\Facades\Utils;

use App\Services\Utils\Unsplash\UnsplashService;
use App\Services\Utils\UtilsService;
use App\Services\Utils\Version\VersionService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static UnsplashService getUnsplashManager()
 * @method static VersionService getVersionManager()
 */
class Utils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UtilsService::class;
    }
}
