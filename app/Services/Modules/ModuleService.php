<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use ZipArchive;

class ModuleService
{
    /**
     * Checks if a settings page exists for a given module.
     *
     * @param  string  $moduleName  The name of the module.
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
     * @param  string  $moduleName  The name of the module.
     * @return string|null The URL of the settings page for the module, or null if the module does not have a settings page.
     */
    public function getSettingsPage(string $moduleName): ?string
    {
        if ($this->hasSettingsPage($moduleName)) {
            return route('modules.'.$moduleName.'.settings');
        }

        return null;
    }

    /**
     * Install a module from a zip file.
     *
     * @param  string  $path  The path to the zip file.
     * @return bool Returns true if the module is successfully installed, false otherwise.
     */
    public function installModule(string $path): bool
    {
        $destinationPath = base_path('modules');

        $zip = new ZipArchive;
        $zipStatus = $zip->open(storage_path($path));

        if ($zipStatus === true) {

            $zip->extractTo($destinationPath);
            $zip->close();

            File::deleteDirectory(storage_path('app/temp'));

            return true;
        } else {
            return false;
        }
    }
}
