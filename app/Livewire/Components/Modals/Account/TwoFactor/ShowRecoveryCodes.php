<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Facades\UserManager;
use App\Models\UserRecoveryCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ShowRecoveryCodes extends ModalComponent
{

    public $recoveryCodes;
    public $password;
    public $user;

    public function showRecoveryCodes()
    {
        if (!Auth::validate(['email' => $this->user->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        $this->recoveryCodes = UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

        activity()
            ->logName('account')
            ->description('account:two_factor.recovery_codes.show')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();
    }

    public function regenerateRecoveryCodes()
    {
        $this->recoveryCodes = [];

        $this->recoveryCodes = UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();

        activity()
            ->logName('account')
            ->description('account:two_factor.recovery_codes.regenerate')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

    }

    public function downloadRecoveryCodes()
    {
        activity()
            ->logName('account')
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

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.show-recovery-codes');
    }
}
