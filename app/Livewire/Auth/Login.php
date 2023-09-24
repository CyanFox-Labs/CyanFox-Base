<?php

namespace App\Livewire\Auth;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
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
        }
    }

    public function checkTwoFactorCode()
    {
        if ($this->setRateLimit()) {
            return;
        }

        $auth = new AuthController();

        if ($auth->checkTwoFactorKey($this->user, $this->two_factor_code)) {
            Auth::login($this->user);
            return redirect('/');
        }

        session()->flash('error', __('Invalid two factor code.'));
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
            } else {
                $this->redirect('/');
            }
        } else {
            session()->flash('error', __('Invalid password.'));
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
