<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\UserManager;
use App\Models\Session;
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

    public function setupPassword() {
        $this->validate([
            'newPassword' => 'required|max:255|same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        $this->user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        activity()
            ->logName('account')
            ->description('account:password.setup')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/setup_password.notifications.password_updated'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.setup-password');
    }
}
