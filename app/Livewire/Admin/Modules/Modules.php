<?php

namespace App\Livewire\Admin\Modules;

use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Nwidart\Modules\Facades\Module;
use Route;

class Modules extends Component
{
    public $modules = [];

    public function mount()
    {
        $modules = Module::all();

        $this->modules = array_map(function ($module) {
            return [
                'name' => $module->getName(),
                'enabled' => $module->isEnabled(),
                'hasSettingsPage' => $this->checkIfModuleHasSettingsPage($module->getName()),
            ];
        }, $modules);
    }

    public function disableModule($name)
    {
        $module = Module::find($name);

        $module->disable();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_disabled'))
            ->success()
            ->send();

        $this->dispatch('refresh');
    }

    public function enableModule($name)
    {
        $module = Module::find($name);

        $module->enable();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_enabled'))
            ->success()
            ->send();

        $this->dispatch('refresh');
    }

    public function deleteModule($name)
    {
        $module = Module::find($name);

        $module->delete();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_deleted'))
            ->success()
            ->send();

        $this->dispatch('refresh');
    }

    public function checkIfModuleHasSettingsPage($name)
    {
        if (Route::has('modules.' . $name . '.settings')) {
            return true;
        }

        return false;
    }

    #[On('refresh')]
    public function render()
    {
        $this->mount();
        return view('livewire.admin.modules.modules')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.modules.modules')]);
    }
}
