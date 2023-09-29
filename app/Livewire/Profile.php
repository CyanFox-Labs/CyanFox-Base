<?php

namespace App\Livewire;

use App\Http\Controllers\Auth\AuthController;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Title;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Profile extends Component
{

    public $passwords = [
        'logoutAllSessions' => '',
        'updateProfileInfos' => '',
        'enable2fa' => '',
        'disable2fa' => '',
        'showRecoveryKeys' => ''
    ];


    /* Theme & Language */
    public function changeLanguage($lang)
    {

        if ($lang == Auth::user()->language) {
            return;
        }

        Auth::user()->language = $lang;

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Language changed successfully!')
                ->success()
                ->send();
            return redirect()->route('profile');
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    public function changeTheme($theme)
    {
        if ($theme == Auth::user()->theme) {
            return;
        }

        Auth::user()->theme = $theme;

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Theme changed successfully!')
                ->success()
                ->send();
            return redirect()->route('profile');
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    /* Sessions */
    public $passwordLogoutSession = [];

    public function logoutSession($sessionId)
    {
        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwordLogoutSession[$sessionId]])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        AuthController::regenerateRememberToken(Auth::user());
        DB::table('sessions')->where('id', $sessionId)->delete();
        Notification::make()
            ->title('Session logged out successfully!')
            ->success()
            ->send();
    }

    public function logoutAllSessions()
    {
        try {
            Auth::logoutOtherDevices($this->passwords['logoutAllSessions']);
            Notification::make()
                ->title('All sessions logged out successfully!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }
    }

    public function getSessionData()
    {
        $userSessions = DB::table('sessions')->where('user_id', Auth::user()->getAuthIdentifier())->get();
        $sessionData = [];

        foreach ($userSessions as $session) {

            if (!$session->user_id === Auth::user()->getAuthIdentifier()) {
                continue;
            }

            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);

            $platform = $agent->browser() . " " . $agent->platform();

            $isCurrentSession = (session()->getId() === $session->id);

            $deviceType = $agent->isDesktop() ? 'Desktop' : ($agent->isPhone() ? 'Phone' : 'Tablet');

            $ip = $session->ip_address;

            $sessionData[] = [
                'id' => $session->id,
                'ip' => $ip,
                'agent' => $agent,
                'platform' => $platform,
                'deviceType' => $deviceType,
                'isCurrentSession' => $isCurrentSession
            ];
        }

        usort($sessionData, fn($a, $b) => $b['isCurrentSession'] <=> $a['isCurrentSession']);

        return $sessionData;
    }

    /* Profile Information */
    public $first_name;
    public $last_name;
    public $username;
    public $email;

    public function updateProfileInfos()
    {
        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['updateProfileInfos']])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        try {
            $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email'
            ]);
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Please fill all fields correctly!')
                ->danger()
                ->send();
            return;
        }

        Auth::user()->first_name = $this->first_name;
        Auth::user()->last_name = $this->last_name;
        Auth::user()->username = $this->username;
        Auth::user()->email = $this->email;

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Profile updated successfully!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    /* Password */
    public $current_password = '';
    public $new_password = '';
    public $confirm_password = '';

    public function updatePassword()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->current_password])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        try {
            $this->validate([
                'new_password' => 'required',
                'confirm_password' => 'required'
            ]);
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Please fill all fields correctly!')
                ->danger()
                ->send();
            return;
        }

        if ($this->new_password !== $this->confirm_password) {
            Notification::make()
                ->title('Passwords do not match!')
                ->danger()
                ->send();
            return;
        }

        Auth::user()->password = bcrypt($this->new_password);

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Password updated successfully!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    /* Two Factor */
    public $two_factor_key = '';

    public function activateTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['enable2fa']])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        if (!AuthController::checkTwoFactorKey(Auth::user(), $this->two_factor_key, false)) {
            Notification::make()
                ->title('Wrong key!')
                ->danger()
                ->send();
            return;
        }

        Auth::user()->two_factor_enabled = true;

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Two Factor Authentication enabled successfully!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    public function disableTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['disable2fa']])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        Auth::user()->two_factor_enabled = false;

        if (Auth::user()->save()) {
            Notification::make()
                ->title('Two Factor Authentication disabled successfully!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }
    }

    public function showRecoveryKeys()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['showRecoveryKeys']])) {
            Notification::make()
                ->title('Wrong password!')
                ->danger()
                ->send();
            return;
        }

        $recovery_codes_array = decrypt(Auth::user()->two_factor_recovery_codes);
        $recovery_codes = json_decode($recovery_codes_array, true);

        session()->flash('recovery_codes', $recovery_codes);
        return redirect()->route('profile');
    }

    public function getTwoFactorImage()
    {
        $two_factor = new Google2FA();
        $qr_code = $two_factor->getQRCodeUrl(env('APP_NAME'), Auth::user()->email, decrypt(Auth::user()->two_factor_secret));
        return base64_encode(QrCode::format('svg')->size(200)->generate($qr_code));
    }


    public function mount()
    {
        $this->first_name = Auth::user()->first_name;
        $this->last_name = Auth::user()->last_name;
        $this->username = Auth::user()->username;
        $this->email = Auth::user()->email;
    }

    #[Title('Profile')]
    public function render()
    {
        return view('livewire.profile', [
            'sessionData' => $this->getSessionData(),
            'twoFactorImage' => $this->getTwoFactorImage()
        ]);
    }
}
