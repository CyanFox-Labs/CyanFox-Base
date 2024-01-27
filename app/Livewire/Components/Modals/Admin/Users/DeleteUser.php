<?php

namespace App\Livewire\Components\Modals\Admin\Users;

use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;

class DeleteUser extends ModalComponent
{
    public $userId;

    public function deleteUser()
    {

        try {
            $user = User::findOrFail($this->userId);
            $user->delete();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        Notification::make()
            ->title(__('components/modals/admin/delete_user.notifications.user_deleted'))
            ->success()
            ->send();

        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.users.delete-user');
    }
}
