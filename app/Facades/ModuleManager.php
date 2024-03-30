<?php

namespace App\Facades;

use App\Services\Modules\ModuleService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool hasSettingsPage(string $moduleName)
 * @method static string|null getSettingsPage(string $moduleName)
 * @method static bool installModule(string $path)
 */
class ModuleManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ModuleService::class;
    }
}
