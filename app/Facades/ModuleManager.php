<?php

namespace App\Facades;

use App\Services\Modules\ModuleService;
use App\Services\Modules\SpecificModuleService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static SpecificModuleService getModule(string $module)
 * @method static array getModules()
 * @method static bool installModule(string $path)
 * @method static bool installModuleFromURL(string $url)
 */
class ModuleManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ModuleService::class;
    }
}
