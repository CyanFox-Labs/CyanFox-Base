<?php

namespace App\Livewire\Auth;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    use WithRateLimiting;

    public $user;
    public $username;
    public $password;
    public $remember_me = null;
    public $two_factor_enabled = false;
    public $two_factor_code = null;

    public $rateLimitTime;

    public function setLanguage($language)
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('messages.notifications.language_changed'))
            ->success()
            ->send();
        return redirect()->route('login');
    }

    public function setRateLimit()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->rateLimitTime = $exception->secondsUntilAvailable;
            return true;
        }
        return false;
    }

    public function checkIfUserExits($username)
    {
        if ($this->setRateLimit()) {
            return;
        }
        if ($username == null || $username == '') {
            return;
        }
        $this->user = User::where('username', $username)->first();
        if ($this->user == null) {
            $this->user = false;
            throw ValidationException::withMessages([
                'username' => __('pages/auth/login.user_not_found'),
            ]);
        }
        $this->resetErrorBag('username');
        $this->dispatch('userExists');
    }

    public function checkTwoFactorCode()
    {
        if ($this->setRateLimit()) {
            return;
        }

        if (AuthController::checkTwoFactorCode($this->user, $this->two_factor_code)) {
            Auth::login($this->user);

            activity('system')
                ->performedOn($this->user)
                ->causedByAnonymous()
                ->withProperty('name', $this->user->username . ' (' . $this->user->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('auth.two_factor_success');
            return redirect('/');
        }

        activity('system')
            ->performedOn($this->user)
            ->causedByAnonymous()
            ->withProperty('name', $this->user->username . ' (' . $this->user->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('auth.two_factor_failed');
        throw ValidationException::withMessages([
            'two_factor_code' => __('validation.custom.two_factor_code'),
        ]);
   }

    public function attemptLogin()
    {
        if ($this->setRateLimit()) {
            return;
        }

        $credentials = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        $this->checkIfUserExits($this->username);

        if (Auth::attempt($credentials, $this->remember_me)) {
            if ($this->user->two_factor_enabled) {
                Auth::logout();
                $this->two_factor_enabled = true;

                activity('system')
                    ->performedOn($this->user)
                    ->causedByAnonymous()
                    ->withProperty('name', $this->user->username . ' (' . $this->user->email . ')')
                    ->withProperty('ip', request()->ip())
                    ->log('auth.two_factor_requested');
            } else {

                activity('system')
                    ->performedOn($this->user)
                    ->causedByAnonymous()
                    ->withProperty('name', $this->user->username . ' (' . $this->user->email . ')')
                    ->withProperty('ip', request()->ip())
                    ->log('auth.login');
                $this->redirect('/');
            }
        } else {
            activity('system')
                ->performedOn($this->user)
                ->causedByAnonymous()
                ->withProperty('name', $this->username)
                ->withProperty('ip', request()->ip())
                ->log('auth.failed');

            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest', [
                'title' => __('pages/auth/login.buttons.login')
            ]);
    }
}
