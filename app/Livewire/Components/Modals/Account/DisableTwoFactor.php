<?php

namespace App\Livewire\Components\Modals\Account;

use Auth;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class DisableTwoFactor extends ModalComponent
{

    public $password;

    function disableTwoFactor()
    {
        if (!Auth::validate(['email' => auth()->user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        try {
            auth()->user()->generateTwoFactorSecret();
            auth()->user()->generateRecoveryCodes();

            auth()->user()->update([
                'two_factor_enabled' => false
            ]);
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        Notification::make()
            ->title(__('components/modals/account/disable_two_factor.notifications.two_factor_disabled'))
            ->success()
            ->send();

        return redirect()->route('account.profile');
    }

    public function render()
    {
        return view('livewire.components.modals.account.disable-two-factor');
    }
}
