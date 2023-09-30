<?php

namespace App\Livewire;

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Components\Modals\Profile\UpdateProfile;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Livewire;

class Profile extends Component
{

    /* Profile */
    public $first_name;
    public $last_name;
    public $username;
    public $email;

    public function updateProfile()
    {

        try {
            $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email'
            ]);
        } catch (ValidationException $e) {
            Notification::make()
                ->title(__('messages.fill_all_fields_correctly'))
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
                ->title(__('pages/profile.profile_updated'))
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

    /* Theme & Language */
    public function changeLanguage($lang)
    {

        if ($lang == Auth::user()->language) {
            return;
        }

        Auth::user()->language = $lang;

        if (Auth::user()->save()) {
            Notification::make()
                ->title(__('messages.language_changed'))
                ->success()
                ->send();
            return redirect()->route('profile');
        } else {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
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
                ->title(__('pages/profile.theme_changed'))
                ->success()
                ->send();
            return redirect()->route('profile');
        } else {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
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
                ->title(__('messages.invalid_password'))
                ->danger()
                ->send();
            return;
        }

        AuthController::regenerateRememberToken(Auth::user());
        DB::table('sessions')->where('id', $sessionId)->delete();
        Notification::make()
            ->title(__('pages/profile.session_logged_out'))
            ->success()
            ->send();
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


    /* Password */
    public $current_password = '';
    public $new_password = '';
    public $confirm_password = '';

    public function updatePassword()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->current_password])) {
            Notification::make()
                ->title(__('messages.invalid_password'))
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
                ->title(__('messages.fill_all_fields_correctly'))
                ->danger()
                ->send();
            return;
        }

        if ($this->new_password !== $this->confirm_password) {
            Notification::make()
                ->title(__('pages/profile.password_not_match'))
                ->danger()
                ->send();
            return;
        }

        Auth::user()->password = bcrypt($this->new_password);

        if (Auth::user()->save()) {
            Notification::make()
                ->title(__('pages/profile.password_updated'))
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
        ]);
    }
}
