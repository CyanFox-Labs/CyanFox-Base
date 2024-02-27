<?php

namespace App\Livewire\Auth;

use App\Facades\ActivityLogManager;
use App\Facades\Utils\UnsplashManager;
use App\Models\User;
use App\Rules\Password;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
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

    public function checkIfUserExits($email): void
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

    public function resetPassword(): void
    {
        $this->validate([
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        $user = User::where('password_reset_token', $this->resetToken)->first();

        $expirationDate = Carbon::parse($user->password_reset_expiration);

        if ($expirationDate->isPast()) {
            ActivityLogManager::logName('auth')
                ->description('auth:forgot_password.failed')
                ->causer(request()->ip())
                ->subject($user->username)
                ->performedBy($user)
                ->save();

            Notification::make()
                ->title(__('pages/auth/forgot_password.notifications.password_reset_link_expired'))
                ->danger()
                ->send();

            $this->redirect(route('auth.forgot-password', ''), navigate: true);
        } else {

            $user->update([
                'password_reset_token' => null,
                'password_reset_expiration' => null,
                'password' => Hash::make($this->password),
            ]);

            ActivityLogManager::logName('auth')
                ->description('auth:forgot_password.success')
                ->causer($user->username)
                ->subject($user->username)
                ->performedBy($user)
                ->save();

            Notification::make()
                ->title(__('pages/auth/forgot_password.notifications.password_resetted'))
                ->success()
                ->send();

            $this->redirect(route('auth.login'), navigate: true);
        }
    }

    public function sendResetLink(): void
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
                    'captcha' => __('validation.custom.invalid_captcha'),
                ]);
            }
        }

        try {
            $this->user->update([
                'password_reset_token' => Str::random(32),
                'password_reset_expiration' => Carbon::now()->addHours(24),
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        $placeholders = ['username' => $this->user->username,
            'firstName' => $this->user->first_name, 'lastName' => $this->user->last_name,
            'passwordResetToken' => $this->user->password_reset_token,
            'resetLink' => route('auth.forgot-password', [$this->user->password_reset_token])];

        $user = $this->user;

        Mail::send('emails.forgot-password', $placeholders, function ($message) use ($user) {
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

    public function mount(): void
    {

        if ($this->resetToken !== null) {
            $user = User::where('password_reset_token', $this->resetToken)->first();

            if ($user == null) {
                ActivityLogManager::logName('auth')
                    ->description('auth:forgot_password.failed')
                    ->causer(request()->ip())
                    ->save();

                Notification::make()
                    ->title(__('pages/auth/forgot_password.notifications.password_reset_link_invalid'))
                    ->danger()
                    ->send();

                $this->redirect(route('auth.forgot-password', ''), navigate: true);

                return;
            }

            $expirationDate = Carbon::parse($user->password_reset_expiration);

            if ($expirationDate->isPast()) {
                ActivityLogManager::logName('auth')
                    ->description('auth:forgot_password.failed')
                    ->causer(request()->ip())
                    ->subject($user->username)
                    ->performedBy($user)
                    ->save();

                Notification::make()
                    ->title(__('pages/auth/forgot_password.notifications.password_reset_link_expired'))
                    ->danger()
                    ->send();

                $this->redirect(route('auth.forgot-password', ''), navigate: true);

                return;
            }
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
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.forgot-password'),
        ]);
    }
}
