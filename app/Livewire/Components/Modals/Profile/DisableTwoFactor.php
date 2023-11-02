<?php

namespace App\Livewire\Components\Modals\Profile;

use Exception;
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
                'password' => __('validation.current_password'),
            ]);
        }

        Auth::user()->two_factor_enabled = false;

        try {
            Auth::user()->save();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        Notification::make()
            ->title(__('pages/account/messages.notifications.two_factor_disabled'))
            ->success()
            ->send();
        $this->redirect(route('profile'));
    }

    public function render()
    {
        return view('livewire.components.modals.profile.disable-two-factor');
    }
}
