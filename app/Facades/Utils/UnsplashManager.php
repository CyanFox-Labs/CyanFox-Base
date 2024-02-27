<?php

namespace App\Facades\Utils;

use App\Services\Utils\Unsplash\UnsplashService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array returnBackground()
 * @method static string getUTM()
 * @method static array getRandomUnsplashImage()
 */
class UnsplashManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UnsplashService::class;
    }
}
