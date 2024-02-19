<?php

namespace App\Livewire\Components\Modals\Account\TwoFactor;

use App\Models\UserRecoveryCode;
use Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ShowRecoveryCodes extends ModalComponent
{

    public $recoveryCodes;
    public $password;

    public function showRecoveryCodes()
    {
        if (!Auth::validate(['email' => auth()->user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        $recoveryCodes = UserRecoveryCode::where('user_id', auth()->user()->id)->get();

        foreach ($recoveryCodes as $recoveryCode) {
            $this->recoveryCodes[] = decrypt($recoveryCode->code);
        }

        activity()
            ->logName('account')
            ->logMessage('account:two_factor.recovery_codes.show')
            ->causer(auth()->user()->username)
            ->subject(auth()->user()->username)
            ->performedBy(auth()->user()->id)
            ->save();
    }

    public function regenerateRecoveryCodes()
    {
        $this->recoveryCodes = [];

        auth()->user()->generateRecoveryCodes();

        $recoverCodes = UserRecoveryCode::where('user_id', auth()->user()->id)->get();

        foreach ($recoverCodes as $recoverCode) {
            $this->recoveryCodes[] = decrypt($recoverCode->code);
        }

        activity()
            ->logName('account')
            ->logMessage('account:two_factor.recovery_codes.regenerate')
            ->causer(auth()->user()->username)
            ->subject(auth()->user()->username)
            ->performedBy(auth()->user()->id)
            ->save();

    }

    public function downloadRecoveryCodes()
    {
        activity()
            ->logName('account')
            ->logMessage('account:two_factor.recovery_codes.download')
            ->causer(auth()->user()->username)
            ->subject(auth()->user()->username)
            ->performedBy(auth()->user()->id)
            ->save();

        return response()->streamDownload(function () {
            $recoverCodes = UserRecoveryCode::where('user_id', auth()->user()->id)->get();
            $decryptRecoverCodes = '';

            foreach ($recoverCodes as $recoverCode) {
                $decryptRecoverCodes .= decrypt($recoverCode->code) . "\n";
            }

            echo $decryptRecoverCodes;
        }, 'recovery-codes.txt');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.two-factor.show-recovery-codes');
    }
}
