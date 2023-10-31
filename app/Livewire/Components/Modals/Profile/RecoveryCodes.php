<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RecoveryCodes extends ModalComponent
{

    public $password;

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
            Notification::make()
                ->title(__('messages.invalid_password'))
                ->danger()
                ->send();
            return;
        }

        $recovery_codes_array = decrypt(Auth::user()->two_factor_recovery_codes);
        $recovery_codes = json_decode($recovery_codes_array, true);

        session()->flash('recovery_codes', $recovery_codes);
        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.components.modals.profile.recovery-codes');
    }
}
