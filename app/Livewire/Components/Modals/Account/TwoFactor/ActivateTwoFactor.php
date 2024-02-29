<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ActivateTwoFactor extends ModalComponent
{
    public $twoFactorCode;

    public $password;

    public $user;

    public function activateTwoFactor(): void
    {

        if (Hash::check($this->password, $this->user->password)) {
            if (UserManager::getUser($this->user)->getTwoFactorManager()->isTwoFactorEnabled()) {
                if (!UserManager::getUser($this->user)->getTwoFactorManager()->checkTwoFactorCode($this->twoFactorCode, false)) {
                    throw ValidationException::withMessages([
                        'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
                    ]);
                }
            }

            try {
                $this->user->update([
                    'two_factor_enabled' => true,
                ]);

                UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();
            } catch (Exception $e) {
                Notification::make()
                    ->title(__('messages.notifications.something_went_wrong'))
                    ->danger()
                    ->send();

                $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

                return;
            }

            UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

            ActivityLogManager::logName('account')
                ->description('account:two_factor.activate')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            Notification::make()
                ->title(__('account/profile.modals.activate_two_factor.notifications.two_factor_activated'))
                ->success()
                ->send();

            $this->closeModal();
            $this->dispatch('refresh');
        } else {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.activate-two-factor');
    }
}
