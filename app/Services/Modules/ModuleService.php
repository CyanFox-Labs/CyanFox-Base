<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\Route;

class ModuleService
{
    /**
     * Checks if a settings page exists for a given module.
     *
     * @param string $moduleName The name of the module.
     *
     * @return bool Returns true if a settings page exists for the module, false otherwise.
     */
    public function hasSettingsPage(string $moduleName): bool
    {
        if (Route::has('modules.'.$moduleName.'.settings')) {
            return true;
        }

        return false;
    }

    /**
     * Retrieves the settings page URL for the given module name.
     *
     * @param string $moduleName The name of the module.
     *
     * @return string|null The URL of the settings page for the module, or null if the module does not have a settings page.
     */
    public function getSettingsPage(string $moduleName): ?string
    {
        if ($this->hasSettingsPage($moduleName)) {
            return route('modules.'.$moduleName.'.settings');
        }

        return null;
    }
}
