<?php

namespace App\Livewire;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Title;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Profile extends Component
{

    use LivewireAlert;

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
            $this->flash('success', 'Language changed successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    public function changeTheme($theme)
    {
        if ($theme == Auth::user()->theme) {
            return;
        }

        Auth::user()->theme = $theme;

        if (Auth::user()->save()) {
            $this->flash('success', 'Theme changed successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    /* Sessions */
    public $passwordLogoutSession = [];

    public function logoutSession($sessionId)
    {
        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwordLogoutSession[$sessionId]])) {
            $this->alert('error', 'Wrong password!');
            return;
        }

        AuthController::regenerateRememberToken(Auth::user());
        DB::table('sessions')->where('id', $sessionId)->delete();
        $this->flash('success', 'Session logged out successfully!', [], route('profile'));
    }

    public function logoutAllSessions()
    {
        try {
            Auth::logoutOtherDevices($this->passwords['logoutAllSessions']);
            $this->flash('success', 'All sessions logged out successfully!', [], route('profile'));
        } catch (\Exception $e) {
            $this->alert('error', 'Wrong password!');
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
    public $first_name = '';
    public $last_name = '';
    public $username = '';
    public $email = '';

    public function updateProfileInfos()
    {
        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['updateProfileInfos']])) {
            $this->alert('error', 'Wrong password!');
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
            $this->alert('error', 'Please fill all fields correctly!');
            return;
        }

        Auth::user()->first_name = $this->first_name;
        Auth::user()->last_name = $this->last_name;
        Auth::user()->username = $this->username;
        Auth::user()->email = $this->email;

        if (Auth::user()->save()) {
            $this->flash('success', 'Profile updated successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    /* Password */
    public $current_password = '';
    public $new_password = '';
    public $confirm_password = '';

    public function updatePassword()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->current_password])) {
            $this->alert('error', 'Wrong password!');
            return;
        }

        try {
            $this->validate([
                'new_password' => 'required',
                'confirm_password' => 'required'
            ]);
        } catch (ValidationException $e) {
            $this->alert('error', 'Please fill all fields correctly!');
            return;
        }

        if ($this->new_password !== $this->confirm_password) {
            $this->alert('error', 'Passwords do not match!');
            return;
        }

        Auth::user()->password = bcrypt($this->new_password);

        if (Auth::user()->save()) {
            $this->flash('success', 'Password updated successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    /* Two Factor */
    public $two_factor_key = '';

    public function activateTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['enable2fa']])) {
            $this->alert('error', 'Wrong password!');
            return;
        }

        if (!AuthController::checkTwoFactorKey(Auth::user(), $this->two_factor_key, false)) {
            $this->alert('error', 'Wrong key');
            return;
        }

        Auth::user()->two_factor_enabled = true;

        if (Auth::user()->save()) {
            $this->flash('success', 'Two Factor Authentication activated successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    public function disableTwoFactor() {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['disable2fa']])) {
            $this->alert('error', 'Wrong password!');
            return;
        }

        Auth::user()->two_factor_enabled = false;

        if (Auth::user()->save()) {
            $this->flash('success', 'Two Factor Authentication disabled successfully!', [], route('profile'));
        } else {
            $this->alert('error', 'Something went wrong!');
        }
    }

    public function showRecoveryKeys() {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->passwords['showRecoveryKeys']])) {
            $this->alert('error', 'Wrong password!');
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



    #[Title('Profile')]
    public function render()
    {
        return view('livewire.profile', [
            'sessionData' => $this->getSessionData(),
            'twoFactorImage' => $this->getTwoFactorImage()
        ]);
    }
}
