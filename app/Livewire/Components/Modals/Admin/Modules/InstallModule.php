<?php

namespace App\Livewire\Components\Modals\Admin\Modules;

use App\Facades\ActivityLogManager;
use App\Facades\ModuleManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class InstallModule extends ModalComponent
{
    use WithFileUploads;

    public $module;

    public function installModule()
    {
        $this->validate([
            'module' => 'required|file|mimes:zip',
        ]);

        $path = $this->module->store('temp');
        if (!ModuleManager::installModule('app/'.$path)) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => 'Could not install module. Try again with a different module.']);
            $this->closeModal();
        } else {
            Notification::make()
                ->title(__('admin/modules.modals.install_module.notifications.module_installed'))
                ->success()
                ->send();

            ActivityLogManager::logName('admin')
                ->description('admin:modules.install')
                ->causer(Auth::user()->username)
                ->subject($this->module->getClientOriginalName())
                ->performedBy(Auth::user())
                ->save();

            $this->redirect(route('admin.modules'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.components.modals.admin.modules.install-module');
    }
}
