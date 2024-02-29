<?php

namespace App\Livewire\Components\Modals\Admin\Users;

use App\Facades\ActivityLogManager;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DeleteUser extends ModalComponent
{
    public $userId;

    public function deleteUser(): void
    {

        try {
            $user = User::findOrFail($this->userId);
            Storage::disk('public')->delete('avatars/'.$user->id.'.png');
            $user->delete();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
            ->description('admin:users.delete')
            ->causer(Auth::user()->username)
            ->subject($user->username)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/users.modals.delete_user.notifications.user_deleted'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.admin.users.delete-user');
    }
}
