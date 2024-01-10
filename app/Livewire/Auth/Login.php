<?php

namespace App\Livewire\Auth;

use App\Http\Controllers\API\UnsplashController;
use App\Models\User;
use App\Models\UserRecoveryCode;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    use WithRateLimiting;

    public $unsplash;

    public $user;

    public $twoFactorEnabled = false;
    public $twoFactorCode;

    public $rateLimitTime;

    public $username;
    public $password;
    public $rememberMe;

    public function mount()
    {
        $unsplash = UnsplashController::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }
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
            $this->resetErrorBag('username');
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

            if ($this->user->two_factor_secret == null) {
                $this->user->generateTwoFactorSecret();
            }

            if (UserRecoveryCode::find($this->user->id) == null) {
                $this->user->generateRecoveryCodes();
            }

            if ($this->user->two_factor_enabled) {
                Auth::logout();
                $this->twoFactorEnabled = true;
            } else {
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
            Auth::login($this->user);
            return redirect('/');
        }

        throw ValidationException::withMessages([
            'twoFactorCode' => __('validation.custom.two_factor_code'),
        ]);
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
