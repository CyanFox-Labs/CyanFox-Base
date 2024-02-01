<?php

namespace App\Livewire\Auth;

use App\Helpers\UnsplashHelper;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
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
    public $captcha;

    public function mount()
    {
        if (!$this->redirect == null && !str_starts_with($this->redirect, setting('app_url'))) {
            $this->redirect = setting('app_url');
        }

        $unsplash = UnsplashHelper::returnBackground();

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

        if (setting('auth_enable_captcha')) {
            $validator = Validator::make(['captcha' => $this->captcha], ['captcha' => 'required|captcha']);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'captcha' => __('validation.custom.invalid_captcha')
                ]);
            }
        }

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
                if (setting('emails_login_enabled')) {
                    $this->sendMail($this->user);
                }

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

            if (setting('emails_login_enabled')) {
                $this->sendMail($this->user);
            }

            if ($this->redirect) {
                return redirect()->to($this->redirect);
            }

            return redirect('/');
        }

        throw ValidationException::withMessages([
            'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
        ]);
    }

    private function sendMail($user)
    {
        $placeholders = ['username' => $user->username,
            'firstName' => $user->first_name, 'lastName' => $user->last_name,
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
        ];

        Mail::send('emails.login', $placeholders, function ($message) use ($user, $placeholders) {
            $message->to($user->email, str_replace(
                ['{username}', '{firstName}', '{lastName}', '{ipAddress}', '{userAgent}'],
                [$user->username, $user->first_name, $user->last_name, request()->ip(), request()->userAgent()],
                setting('emails_login_title')
            ))
                ->subject(str_replace(
                    ['{username}', '{firstName}', '{lastName}', '{ipAddress}', '{userAgent}'],
                    [$user->username, $user->first_name, $user->last_name, request()->ip(), request()->userAgent()],
                    setting('emails_login_subject')
                ));
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }


    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.login')
        ]);
    }
}
