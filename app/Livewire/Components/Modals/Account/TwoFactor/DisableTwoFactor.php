<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use Auth;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
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

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.disable-two-factor');
    }
}
