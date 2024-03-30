<?php

namespace App\Livewire\Components\Modals\Admin\Modules;

use App\Facades\ActivityLogManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;
use Nwidart\Modules\Facades\Module;

class DeleteModule extends ModalComponent
{
    public $moduleName;

    public function deleteModule(): void
    {

        try {
            $module = Module::find($this->moduleName);
            $module->delete();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('account')
            ->description('admin:modules.delete')
            ->causer(Auth::user()->username)
            ->subject($module->getName())
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/modules.modals.delete_module.notifications.module_deleted'))
            ->success()
            ->send();

        $this->closeModal();
        $this->redirect(route('admin.modules'), navigate: true);
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.admin.modules.delete-module');
    }
}
