<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class LogoutOtherDevices extends ModalComponent
{
    public $user;

    public function logoutOtherDevices(): void
    {

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        ActivityLogManager::logName('account')
            ->description('account:sessions.logout_all')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/profile.modals.logout_other_devices.notifications.other_devices_logged_out'))
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
        return view('livewire.components.modals.account.logout-other-devices');
    }
}
