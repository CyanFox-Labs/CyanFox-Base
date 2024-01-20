<?php

namespace App\Livewire\Auth;

use App\Http\Controllers\API\UnsplashController;
use App\Models\User;
use App\Models\UserRecoveryCode;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;

class Login extends Component
{
    use WithRateLimiting;

    public $unsplash;

    public $user;

    public $rateLimitTime;

    #[Url]
    public $redirect;

    public $username;
    public $password;

    public $twoFactorEnabled = false;
    public $twoFactorCode;

    public $rememberMe;

    public $language;

    public function mount()
    {
        if (!$this->redirect == null && !str_starts_with($this->redirect, setting('app_url'))) {
            $this->redirect = setting('app_url');
        }

        $unsplash = UnsplashController::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }

        $this->language = Request::cookie('language');
    }

    public function changeLanguage($language)
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('pages/auth/messages.notifications.language_changed'))
            ->success()
            ->send();
        return redirect()->route('auth.login', ['redirect' => $this->redirect]);
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
        if ($username == null || $username == '') {
            return;
        }

        if ($this->setRateLimit()) {
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

        if (Auth::attempt($credentials, $this->rememberMe)) {

            if ($this->user->disabled) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => __('pages/auth/login.user_disabled'),
                ]);
            }

            if ($this->user->two_factor_enabled) {
                Auth::logout();
                $this->twoFactorEnabled = true;
            } else {
                if ($this->redirect) {
                    return redirect()->to($this->redirect);
                }

                $this->redirect(route('home'));
            }
        } else {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function checkTwoFactorCode()
    {
        if ($this->setRateLimit()) {
            return;
        }

        if (!$this->user->two_factor_enabled) {
            return;
        }

        if ($this->user->checkTwoFactorCode($this->twoFactorCode)) {
            Auth::login($this->user, $this->rememberMe);

            if ($this->redirect) {
                return redirect()->to($this->redirect);
            }

            return redirect('/');
        }

        throw ValidationException::withMessages([
            'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
        ]);
    }


    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.login')
        ]);
    }
}
