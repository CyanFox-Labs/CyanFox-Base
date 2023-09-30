<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DisableTwoFactor extends Component
{
    public $password;

    public function disableTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {
            Notification::make()
                ->title(__('messages.invalid_password'))
                ->danger()
                ->send();
            return;
        }

        Auth::user()->two_factor_enabled = false;

        if (Auth::user()->save()) {
            Notification::make()
                ->title(__('pages/profile.disable_two_factor.disabled'))
                ->success()
                ->send();
            $this->redirect(route('profile'));
        } else {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.components.modals.profile.disable-two-factor');
    }
}
