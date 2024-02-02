<?php

namespace App\Livewire\Admin\Modules;

use Filament\Notifications\Notification;
use Livewire\Component;
use Nwidart\Modules\Facades\Module;

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

        return redirect()->route('admin.modules');
    }

    public function enableModule($name)
    {
        $module = Module::find($name);

        $module->enable();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_enabled'))
            ->success()
            ->send();

        return redirect()->route('admin.modules');
    }

    public function deleteModule($name)
    {
        $module = Module::find($name);

        $module->delete();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_deleted'))
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.modules.modules')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.modules.modules')]);
    }
}