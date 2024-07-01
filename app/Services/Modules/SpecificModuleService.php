<?php

namespace App\Services\Modules;

use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class SpecificModuleService
{
    /**
     * Represents a module in the Laravel application.
     *
     * @var string
     */
    private $module;

    /**
     * Sets the module property by finding the module with the given ID
     *
     * @param  int  $module  The ID of the module to be found
     */
    public function __construct($module)
    {
        $this->module = Module::find($module);
    }

    /**
     * Get the module.
     *
     * @return Module|null The module instance or null if not found.
     */
    public function get(): ?Module
    {
        return $this->module;
    }

    /**
     * Get the requirements for the module
     *
     * @return array|null The requirements for the module, or null if not set
     */
    public function getRequirements(): ?array
    {
        return $this->module->get('requirements');
    }

    /**
     * Check if the module is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        if ($this->module === null) {
            return false;
        }

        return Module::isEnabled($this->module->getName());
    }

    /**
     * Check if the module is disabled.
     *
     * @return bool
     */
    public function isDisabled()
    {
        if ($this->module === null) {
            return false;
        }

        return Module::isDisabled($this->module->getName());
    }

    /**
     * Enable the module
     *
     * @return bool Returns true if the module was enabled successfully, false otherwise
     */
    public function enable(): bool
    {
        $requirements = $this->getRequirements();

        foreach ($requirements as $requirement) {
            if (!Module::isEnabled($requirement)) {
                return false;
            }
        }

        $this->module->enable();

        return true;
    }

    /**
     * Disables a module.
     */
    public function disable(): void
    {
        $this->module->disable();
    }

    /**
     * Delete the module.
     */
    public function delete(): void
    {
        $this->module->delete();
    }

    /**
     * Runs the migrations for a specific module.
     */
    public function runMigrations(): void
    {
        Artisan::call('module:migrate', ['module' => $this->module->getName()]);
    }

    /**
     * Get the version of the module.
     *
     * @return string The version of the module.
     */
    public function getVersion(): string
    {
        return $this->module->get('version');
    }

    /**
     * Retrieve the template version for the current module.
     *
     * @return string|null The template version, or null if not set.
     */
    public function getTemplateVersion(): ?string
    {
        return $this->module->get('template_version');
    }

    /**
     * Retrieve the author of a module.
     *
     * @return array|null The authors of the module, or null if not found.
     */
    public function getAuthor(): ?array
    {
        return $this->module->get('authors');
    }

    /**
     * Get the keywords from the module
     *
     * @return array|null The keywords for the module, or null if not set
     */
    public function getKeywords(): ?array
    {
        return $this->module->get('keywords');
    }

    /**
     * Get the description from the module
     *
     * @return string|null The description for the module, or null if not set
     */
    public function getDescription(): ?string
    {
        return $this->module->get('description');
    }

    /**
     * Get the name of the module
     *
     * @return string The name of the module
     */
    public function getName(): string
    {
        return $this->module->getName();
    }

    /**
     * Get the URL of the settings page.
     *
     * @return string|null The URL of the settings page or null if it does not exist.
     */
    public function getSettingsPage(): ?string
    {
        if ($this->module === null) {
            return null;
        }
        if ($this->module->get('settings_page') !== null) {
            return route($this->module->get('settings_page'));
        }

        return null;
    }
}
