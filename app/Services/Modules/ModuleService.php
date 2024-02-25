<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\Route;

class ModuleService
{

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
