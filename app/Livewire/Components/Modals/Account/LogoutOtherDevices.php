<?php

namespace App\Livewire\Components\Modals\Account;

use App\Models\Session;
use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;

class LogoutOtherDevices extends ModalComponent
{
    public function logoutOtherDevices()
    {

        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('components/modals/account/sessions.notifications.logged_out_other_devices'))
            ->success()
            ->send();

        return redirect()->route('account.profile', ['tab' => 'sessions']);
    }

    public function render()
    {
        return view('livewire.components.modals.account.logout-other-devices');
    }
}
