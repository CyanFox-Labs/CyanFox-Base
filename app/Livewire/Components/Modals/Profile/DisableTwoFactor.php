<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DisableTwoFactor extends ModalComponent
{
    public $password;

    public function disableTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('messages.invalid_password'),
            ]);
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
