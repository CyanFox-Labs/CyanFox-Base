<?php

namespace App\Livewire\Components\Modals\Admin\Groups;

use App\Facades\ActivityLogManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class DeleteGroup extends ModalComponent
{
    public $groupId;

    public function deleteGroup(): void
    {
        try {
            $group = Role::findOrFail($this->groupId);
            $group->delete();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
            ->description('admin:groups.delete')
            ->causer(Auth::user()->username)
            ->subject($group->name)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/groups.modals.delete_group.notifications.group_deleted'))
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
