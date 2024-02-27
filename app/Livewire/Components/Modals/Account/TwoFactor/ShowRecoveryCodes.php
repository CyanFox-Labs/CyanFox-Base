<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShowRecoveryCodes extends ModalComponent
{
    public $recoveryCodes;

    public $password;

    public $user;

    public function showRecoveryCodes(): void
    {
        if (Hash::make($this->password, $this->user->password)) {
            $this->recoveryCodes = UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

            ActivityLogManager::logName('account')
                ->description('account:two_factor.recovery_codes.show')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();
        } else {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function regenerateRecoveryCodes(): void
    {
        $this->recoveryCodes = [];

        $this->recoveryCodes = UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

        ActivityLogManager::logName('account')
            ->description('account:two_factor.recovery_codes.regenerate')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

    }

    public function downloadRecoveryCodes(): StreamedResponse
    {
        ActivityLogManager::logName('account')
            ->description('account:two_factor.recovery_codes.download')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        return response()->streamDownload(function () {
            $recoveryCodes = implode(PHP_EOL, $this->recoveryCodes);

            echo $recoveryCodes;
        }, 'recovery-codes.txt');
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.show-recovery-codes');
    }
}
