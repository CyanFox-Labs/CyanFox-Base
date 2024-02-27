<?php

namespace App\Facades\Utils;

use App\Services\Utils\Version\VersionService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getCurrentTemplateVersion()
 * @method static string getCurrentProjectVersion()
 * @method static bool isDevVersion()
 * @method static string | bool getRemoteTemplateVersion()
 * @method static string | bool getRemoteProjectVersion()
 * @method static bool isTemplateUpToDate()
 * @method static bool isProjectUpToDate()
 */
class VersionManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VersionService::class;
    }
}
