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

class DisableTwoFactor extends ModalComponent
{
    public $password;

    public $user;

    public function disableTwoFactor(): void
    {
        if (Hash::check($this->password, $this->user->password)) {
            try {
                UserManager::getUser($this->user)->getTwoFactorManager()->generateTwoFactorSecret();
                UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

                $this->user->update([
                    'two_factor_enabled' => false,
                ]);
            } catch (Exception $e) {
                Notification::make()
                    ->title(__('messages.notifications.something_went_wrong'))
                    ->danger()
                    ->send();

                $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

                return;
            }

            ActivityLogManager::logName('account')
                ->description('account:two_factor.disable')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            Notification::make()
                ->title(__('account/profile.modals.disable_two_factor.notifications.two_factor_disabled'))
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
        return view('livewire.components.modals.account.two-factor.disable-two-factor');
    }
}
