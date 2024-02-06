<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Livewire\Account\Profile;
use App\Models\Session;
use Auth;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ActivateTwoFactor extends ModalComponent
{

    public $twoFactorCode;
    public $password;

    public function activateTwoFactor()
    {

        if (!Auth::validate(['email' => auth()->user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        if(!auth()->user()->checkTwoFactorCode($this->twoFactorCode, false)) {
            throw ValidationException::withMessages([
                'twoFactorCode' => __('validation.custom.invalid_two_factor_code')
            ]);
        }

        try {
            auth()->user()->update([
                'two_factor_enabled' => true
            ]);

            auth()->user()->generateRecoveryCodes();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('components/modals/account/activate_two_factor.notifications.two_factor_enabled'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.activate-two-factor');
    }
}
