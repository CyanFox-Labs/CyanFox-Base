<?php

namespace App\Livewire\Auth;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Facades\Utils\UnsplashManager;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
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

    public function changeLanguage($language): void
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('pages/auth/messages.notifications.language_changed'))
            ->success()
            ->send();

        $this->dispatch('refresh');
    }

    public function setRateLimit(): bool
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->rateLimitTime = $exception->secondsUntilAvailable;

            return true;
        }

        return false;
    }

    public function checkIfUserExits($username): void
    {
        if ($username == null || $username == '') {
            return;
        }

        if ($this->setRateLimit()) {
            return;
        }

        $this->user = UserManager::findUserByUsername($username);
        if ($this->user == null) {
            $this->user = false;
            throw ValidationException::withMessages([
                'username' => __('pages/auth/login.user_not_found'),
            ]);
        }
        $this->resetErrorBag('username');
    }

    public function attemptLogin(): void
    {
        if ($this->setRateLimit()) {
            return;
        }

        $this->checkIfUserExits($this->username);

        if (setting('auth_enable_captcha')) {
            $validator = Validator::make(['captcha' => $this->captcha], ['captcha' => 'required|captcha']);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'captcha' => __('validation.custom.invalid_captcha'),
                ]);
            }
        }

        if (Hash::check($this->password, $this->user->password)) {

            if ($this->user->disabled) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => __('pages/auth/login.user_disabled'),
                ]);
            }

            if ($this->user->two_factor_enabled) {
                Auth::logout();
                $this->twoFactorEnabled = true;

                ActivityLogManager::logName('auth')
                    ->description('auth:login.two_factor')
                    ->causer($this->user->username)
                    ->subject($this->user->username)
                    ->performedBy($this->user)
                    ->save();

            } else {
                if (setting('emails_login_enabled')) {
                    $this->sendMail($this->user);
                }

                if ($this->redirect) {
                    $this->redirect($this->redirect);

                    return;
                }

                ActivityLogManager::logName('auth')
                    ->description('auth:login.success')
                    ->causer($this->user->username)
                    ->subject($this->user->username)
                    ->performedBy($this->user)
                    ->save();

                Auth::login($this->user, $this->rememberMe);
                $this->redirect(route('home'));
            }
        } else {
            ActivityLogManager::logName('auth')
                ->description('auth:login.failed')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function checkTwoFactorCode(): void
    {
        if ($this->setRateLimit()) {
            return;
        }

        if (!$this->user->two_factor_enabled) {
            return;
        }

        if (UserManager::getUser($this->user)->getTwoFactorManager()->checkTwoFactorCode($this->twoFactorCode)) {

            if (setting('emails_login_enabled')) {
                $this->sendMail($this->user);
            }

            if ($this->redirect) {
                $this->redirect($this->redirect);

                return;
            }

            ActivityLogManager::logName('auth')
                ->description('auth:login.two_factor.success')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            Auth::login($this->user, $this->rememberMe);
            $this->redirect(route('home'));
        }

        ActivityLogManager::logName('auth')
            ->description('auth:login.two_factor.failed')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        throw ValidationException::withMessages([
            'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
        ]);
    }

    private function sendMail($user): void
    {
        $placeholders = ['username' => $user->username,
            'firstName' => $user->first_name, 'lastName' => $user->last_name,
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
        ];

        Mail::send('emails.login', $placeholders, function ($message) use ($user) {
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

    public function mount(): void
    {
        if (!$this->redirect == null && !str_starts_with($this->redirect, setting('app_url'))) {
            $this->redirect = setting('app_url');
        }

        $unsplash = UnsplashManager::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }

        $this->language = Request::cookie('language');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.login'),
        ]);
    }
}
