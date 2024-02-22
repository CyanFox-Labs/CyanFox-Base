<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Facades\UserManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DisableTwoFactor extends ModalComponent
{

    public $password;
    public $user;

    function disableTwoFactor()
    {
        if (!Auth::validate(['email' => $this->user->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        try {
            UserManager::getUser($this->user)->getTwoFactorManager()->generateTwoFactorSecret();
            UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

            $this->user->update([
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

        activity()
            ->logName('account')
            ->description('account:two_factor.disable')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/disable_two_factor.notifications.two_factor_disabled'))
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
        return view('livewire.components.modals.account.two-factor.disable-two-factor');
    }
}
