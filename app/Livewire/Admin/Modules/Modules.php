<?php

namespace App\Livewire\Admin\Modules;

use App\Facades\ActivityLogManager;
use App\Facades\ModuleManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Nwidart\Modules\Facades\Module;

class Modules extends Component
{
    public $modules = [];

    public function disableModule($name): void
    {
        try {
            $module = Module::find($name);

            $module->disable();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
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

    public function enableModule($name): void
    {
        try {
            $module = Module::find($name);

            $module->enable();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
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

    public function deleteModule($name): void
    {
        try {
            $module = Module::find($name);

            $module->delete();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
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

    public function mount(): void
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

    #[On('refresh')]
    public function render()
    {
        $this->mount();

        return view('livewire.admin.modules.modules')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.modules.modules')]);
    }
}
