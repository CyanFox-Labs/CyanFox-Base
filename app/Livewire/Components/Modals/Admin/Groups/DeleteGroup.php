<?php

namespace App\Livewire\Components\Modals\Admin\Groups;

use Exception;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class DeleteGroup extends ModalComponent
{
    public $groupId;

    public function deleteGroup()
    {
        try {
            $group = Role::findOrFail($this->groupId);
            $group->delete();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        activity()
            ->logName('admin')
            ->logMessage('admin:groups.delete')
            ->causer(auth()->user()->username)
            ->subject($group->name)
            ->performedBy(auth()->user()->id)
            ->save();

        Notification::make()
            ->title(__('components/modals/admin/delete_group.notifications.group_deleted'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.admin.groups.delete-group');
    }
}
