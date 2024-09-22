<?php

namespace App\Facades\Utils;

use App\Services\Utils\PermissionsService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createPermissions($moduleName, $permissions = [], $cacheDuration = 'forever')
 * @method static void createGroups($moduleName, $groups, $permissions = [], $cacheDuration = 'forever')
 */
class PermissionsManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PermissionsService::class;
    }
}
