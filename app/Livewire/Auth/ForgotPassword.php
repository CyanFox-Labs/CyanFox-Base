<?php

namespace App\Livewire\Auth;

use App\Helpers\UnsplashHelper;
use App\Models\User;
use App\Rules\Password;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class ForgotPassword extends Component
{

    use WithRateLimiting;

    public $unsplash;

    public $user;


    public $email;
    public $resetToken;
    public $password;
    public $passwordConfirmation;

    public $rateLimitTime;


    public $language;
    public $captcha;

    public function mount()
    {

        if ($this->resetToken !== null) {
            $user = User::where('password_reset_token', $this->resetToken)->first();

            if ($user == null) {
                Notification::make()
                    ->title(__('pages/auth/forgot_password.notifications.password_reset_link_invalid'))
                    ->danger()
                    ->send();

                $this->redirect(route('auth.forgot-password', ''), navigate: true);
                return;
            }

            $expirationDate = Carbon::parse($user->password_reset_expiration);

            if ($expirationDate->isPast()) {
                Notification::make()
                    ->title(__('pages/auth/forgot_password.notifications.password_reset_link_expired'))
                    ->danger()
                    ->send();

                $this->redirect(route('auth.forgot-password', ''), navigate: true);
                return;
            }
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

        $this->dispatch('refresh');
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

    public function checkIfUserExits($email)
    {
        if ($email == null || $email == '') {
            $this->resetErrorBag('email');
            return;
        }

        if ($this->setRateLimit()) {
            return;
        }

        $this->user = User::where('email', $email)->first();
        if ($this->user == null) {
            $this->user = false;
            throw ValidationException::withMessages([
                'email' => __('pages/auth/forgot_password.user_not_found'),
            ]);
        }
        $this->resetErrorBag('email');
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        $user = User::where('password_reset_token', $this->resetToken)->first();


        $expirationDate = Carbon::parse($user->password_reset_expiration);

        if ($expirationDate->isPast()) {
            Notification::make()
                ->title(__('pages/auth/forgot_password.notifications.password_reset_link_expired'))
                ->danger()
                ->send();

            $this->redirect(route('auth.forgot-password', ''), navigate: true);
        } else {
            $user->password = bcrypt($this->password);
            $user->password_reset_token = null;
            $user->password_reset_expiration = null;
            $user->save();

            Notification::make()
                ->title(__('pages/auth/forgot_password.notifications.password_resetted'))
                ->success()
                ->send();

            $this->redirect(route('auth.login'), navigate: true);
        }
    }

    public function sendResetLink()
    {
        if ($this->setRateLimit()) {
            return;
        }

        $this->validate([
            'email' => 'required|max:255|email',
        ]);

        $this->checkIfUserExits($this->email);

        if ($this->user == null) {
            return;
        }

        if (setting('auth_enable_captcha')) {
            $validator = Validator::make(['captcha' => $this->captcha], ['captcha' => 'required|captcha']);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'captcha' => __('validation.custom.invalid_captcha')
                ]);
            }
        }

        $this->user->password_reset_token = Str::random(32);
        $this->user->password_reset_expiration = Carbon::now()->addHours(24);
        $this->user->save();

        $placeholders = ['username' => $this->user->username,
            'firstName' => $this->user->first_name, 'lastName' => $this->user->last_name,
            'passwordResetToken' => $this->user->password_reset_token,
            'resetLink' => route('auth.forgot-password', [$this->user->password_reset_token])];

        $user = $this->user;

        Mail::send('emails.forgot-password', $placeholders, function ($message) use ($user, $placeholders) {
            $message->to($user->email, str_replace(
                ['{username}', '{firstName}', '{lastName}'],
                [$user->username, $user->first_name, $user->last_name],
                setting('emails_forgot_password_title')
            ))
                ->subject(str_replace(
                    ['{username}', '{firstName}', '{lastName}'],
                    [$user->username, $user->first_name, $user->last_name],
                    setting('emails_forgot_password_subject')
                ));
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });

        Notification::make()
            ->title(__('pages/auth/forgot_password.notifications.password_reset_link_sent'))
            ->success()
            ->send();

        $this->redirect(route('auth.forgot-password', ''), navigate: true);
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.forgot-password'),
        ]);
    }
}
