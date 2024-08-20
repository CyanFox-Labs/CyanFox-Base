<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
use ZipArchive;

class ModuleService
{
    /**
     * Get a specific module service.
     *
     * @param  string  $module  The module name.
     * @return SpecificModuleService The specific module service instance.
     */
    public function getModule(string $module): SpecificModuleService
    {
        return new SpecificModuleService($module);
    }

    /**
     * Retrieve all modules.
     */
    public function getModules(): array
    {
        return Module::all();
    }

    /**
     * Install a module from a given path.
     *
     * @param  string  $path  The path to the module zip file.
     * @return bool True if the module was installed successfully, false otherwise.
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

    /**
     * Install module from a given URL.
     *
     * @param  string  $url  The URL of the module file to download and install.
     * @return bool Returns true if the module was successfully installed, false otherwise.
     */
    public function installModuleFromURL(string $url): bool
    {
        $destinationPath = base_path('modules');
        $tempPath = storage_path('app/temp');

        $tempFile = $tempPath . '/' . basename($url);

        File::ensureDirectoryExists($tempPath);

        $file = file_get_contents($url);
        file_put_contents($tempFile, $file);

        $zip = new ZipArchive;
        $zipStatus = $zip->open($tempFile);

        if ($zipStatus === true) {

            $zip->extractTo($destinationPath);
            $zip->close();

            File::deleteDirectory($tempPath);

            return true;
        } else {
            return false;
        }
    }
}
