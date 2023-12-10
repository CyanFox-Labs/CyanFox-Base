<?php

namespace App\Livewire\Components\Modals\Profile;

use App\Http\Controllers\Auth\AuthController;
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

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.recovery_codes_downloaded');

            echo $recovery_codes;
        }, 'recovery-codes.txt');

    }

    public function showRecoveryCodes()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }

        $recovery_codes_array = decrypt(Auth::user()->two_factor_recovery_codes);
        $this->recovery_codes = json_decode($recovery_codes_array, true);


        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.recovery_codes_shown');

        $this->dispatch('openModal', 'components.modals.profile.recovery-codes');
    }

    public function regenerate() {
        AuthController::generateRecoveryCodes(Auth::user());

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.recovery_codes_regenerated');

        $this->showRecoveryCodes();
    }

    public function render()
    {
        return view('livewire.components.modals.profile.recovery-codes');
    }
}
