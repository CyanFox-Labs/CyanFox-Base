<?php

namespace App\Livewire\Admin\Modules;

use App\Facades\ModuleManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
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
                'hasSettingsPage' => ModuleManager::hasSettingsPage($module->getName()),
            ];
        }, $modules);
    }

    public function disableModule($name)
    {
        $module = Module::find($name);

        $module->disable();

        activity()
            ->logName('admin')
            ->description('admin:modules.disable')
            ->causer(Auth::user()->username)
            ->subject($module->getName())
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_disabled'))
            ->success()
            ->send();

        $this->redirect(route('admin.modules'), navigate: true);
    }

    public function enableModule($name)
    {
        $module = Module::find($name);

        $module->enable();

        activity()
            ->logName('admin')
            ->description('admin:modules.enable')
            ->causer(Auth::user()->username)
            ->subject($module->getName())
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_enabled'))
            ->success()
            ->send();

        $this->redirect(route('admin.modules'), navigate: true);
    }

    public function deleteModule($name)
    {
        $module = Module::find($name);

        $module->delete();

        activity()
            ->logName('admin')
            ->description('admin:modules.delete')
            ->causer(Auth::user()->username)
            ->subject($name)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('pages/admin/modules/modules.notifications.module_deleted'))
            ->success()
            ->send();

        $this->redirect(route('admin.modules'), navigate: true);
    }

    #[On('refresh')]
    public function render()
    {
        $this->mount();
        return view('livewire.admin.modules.modules')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.modules.modules')]);
    }
}
