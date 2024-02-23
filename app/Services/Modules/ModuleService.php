<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

class ModuleService
{

    public function getAllModules(): array
    {
        return Module::all();
    }

    public function enableModule(string $moduleName): void
    {
        Module::enable($moduleName);
    }

    public function disableModule(string $moduleName): void
    {
        Module::disable($moduleName);
    }

    public function deleteModule(string $moduleName): void
    {
        Module::delete($moduleName);
    }

    public function isModuleEnabled(string $moduleName): bool
    {
        return Module::isEnabled($moduleName);
    }

    public function hasSettingsPage(string $moduleName): bool
    {
        if (Route::has('modules.' . $moduleName . '.settings')) {
            return true;
        }

        return false;
    }

    public function getSettingsPage(string $moduleName): ?string
    {
        if ($this->hasSettingsPage($moduleName)) {
            return route('modules.' . $moduleName . '.settings');
        }
        return null;
    }
}
