<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\UserManager;
use App\Models\Session;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class LogoutOtherDevices extends ModalComponent
{

    public $user;

    public function logoutOtherDevices()
    {

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        activity()
            ->logName('account')
            ->description('account:sessions.logout_all')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/sessions.notifications.logged_out_other_devices'))
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
        return view('livewire.components.modals.account.logout-other-devices');
    }
}
