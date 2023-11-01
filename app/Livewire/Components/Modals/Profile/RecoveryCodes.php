<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RecoveryCodes extends ModalComponent
{

    public $password;
    public $recovery_codes = [];

    public function download()
    {

        return response()->streamDownload(function () {
            $recovery_codes_decrypt = decrypt(Auth::user()->two_factor_recovery_codes);
            $recovery_codes_array = json_decode($recovery_codes_decrypt, true);
            $recovery_codes = '';

            foreach ($recovery_codes_array as $recovery_code) {
                $recovery_codes .= $recovery_code . "\n";
            }

            echo $recovery_codes;
        }, 'recovery-codes.txt');

    }

    public function showRecoveryKeys()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('messages.invalid_password'),
            ]);
        }

        $recovery_codes_array = decrypt(Auth::user()->two_factor_recovery_codes);
        $this->recovery_codes = json_decode($recovery_codes_array, true);

        $this->dispatch('openModal', 'components.modals.profile.recovery-codes');
    }

    public function render()
    {
        return view('livewire.components.modals.profile.recovery-codes');
    }
}
