<?php

namespace App\Livewire\Components\Modals\Admin\Modules;

use Exception;
use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;
use Nwidart\Modules\Facades\Module;

class DeleteModule extends ModalComponent
{

    public $moduleName;

    public function deleteModule()
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

        Notification::make()
            ->title(__('components/modals/admin/delete_module.notifications.module_deleted'))
            ->success()
            ->send();

        return redirect()->route('admin.modules');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.modules.delete-module');
    }
}
