<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class SetupPassword extends ModalComponent
{
    public $user;

    public $newPassword;

    public $passwordConfirmation;

    public function setupPassword(): void
    {
        $this->validate([
            'newPassword' => 'required|max:255|same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        try {
            $this->user->update([
                'password' => Hash::make($this->newPassword),
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        ActivityLogManager::logName('account')
            ->description('account:password.setup')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/profile.modals.setup_password.notifications.password_setup'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.setup-password');
    }
}
