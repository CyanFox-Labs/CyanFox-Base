<?php

namespace App\Facades;

use App\Services\Groups\GroupService;
use App\Services\Modules\ModuleService;
use Illuminate\Support\Facades\Facade;
use Spatie\Permission\Models\Role;

/**
 * @method static array getAllModules()
 * @method static void enableModule(string $moduleName)
 * @method static void disableModule(string $moduleName)
 * @method static void deleteModule(string $moduleName)
 * @method static bool isModuleEnabled(string $moduleName)
 * @method static bool hasSettingsPage(string $moduleName)
 * @method static string|null getSettingsPage(string $moduleName)
 */
class ModuleManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ModuleService::class;
    }

}
