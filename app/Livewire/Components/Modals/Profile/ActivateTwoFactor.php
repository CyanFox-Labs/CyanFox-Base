<?php

namespace App\Livewire\Components\Modals\Profile;

use App\Http\Controllers\Auth\AuthController;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ActivateTwoFactor extends ModalComponent
{
    public $two_factor_key = '';

    public $password;

    public function activateTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('messages.invalid_password')
            ]);
        }

        if (!AuthController::checkTwoFactorCode(Auth::user(), $this->two_factor_key, false)) {
            throw ValidationException::withMessages([
                'two_factor_key' => __('pages/profile.activate_two_factor.wrong_code')
            ]);
        }

        Auth::user()->two_factor_enabled = true;

        if (Auth::user()->save()) {
            Notification::make()
                ->title(__('pages/profile.activate_two_factor.activated'))
                ->success()
                ->send();
            $this->redirect(route('profile'));
        } else {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
        }
    }

    public function getTwoFactorImage()
    {
        $two_factor = new Google2FA();
        $qr_code = $two_factor->getQRCodeUrl(env('APP_NAME'), Auth::user()->email, decrypt(Auth::user()->two_factor_secret));
        return base64_encode(QrCode::format('svg')->size(200)->generate($qr_code));
    }

    public function getTwoFactorSecret()
    {
        return decrypt(Auth::user()->two_factor_secret);
    }


    public function render()
    {
        return view('livewire.components.modals.profile.activate-two-factor', [
            'twoFactorImage' => $this->getTwoFactorImage(),
            'twoFactorSecret' => $this->getTwoFactorSecret()
        ]);
    }
}
