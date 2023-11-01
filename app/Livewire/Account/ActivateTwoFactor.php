<?php

namespace App\Livewire\Account;

use App\Http\Controllers\Auth\AuthController;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ActivateTwoFactor extends Component
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

        if (!AuthController::checkTwoFactorKey(Auth::user(), $this->two_factor_key, false)) {
            throw ValidationException::withMessages([
                'two_factor_key' => __('pages/account/activate-two-factor.wrong_code')
            ]);
        }

        Auth::user()->two_factor_enabled = true;
        Auth::user()->activate_two_factor = 0;

        if (Auth::user()->save()) {
            Notification::make()
                ->title(__('pages/account/activate-two-factor.enabled'))
                ->success()
                ->send();
            $this->redirect(route('home'));
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
        return view('livewire.account.activate-two-factor', [
            'twoFactorImage' => $this->getTwoFactorImage(),
            'twoFactorSecret' => $this->getTwoFactorSecret()
        ])
            ->layout('components.layouts.guest', [
                'title' => __('titles.account.activate_two_factor'),
            ]);
    }
}
