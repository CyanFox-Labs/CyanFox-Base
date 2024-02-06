<?php

namespace App\Livewire\Components\Modals\Account;

use App\Models\Session;
use Filament\Notifications\Notification;
use Hash;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class SetupPassword extends ModalComponent
{

    public $newPassword;
    public $passwordConfirmation;

    public function setupPassword() {
        $this->validate([
            'newPassword' => 'required|max:255|same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->newPassword),
        ]);

        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('components/modals/account/setup_password.notifications.password_updated'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.setup-password');
    }
}
