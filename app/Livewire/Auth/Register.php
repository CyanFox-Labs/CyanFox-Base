<?php

namespace App\Livewire\Auth;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Facades\Utils\UnsplashManager;
use App\Models\User;
use App\Rules\Password;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class Register extends Component
{
    use WithRateLimiting;

    public $unsplash;

    public $user;

    public $firstName;

    public $lastName;

    public $username;

    public $email;

    public $password;

    public $passwordConfirmation;

    public $rateLimitTime;

    public $captcha;

    public $language;

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

    public function register(): void
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        if ($this->setRateLimit()) {
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
            $user = User::create([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('auth')
            ->description('auth:register.success')
            ->causer($user->username)
            ->subject($user->username)
            ->performedBy($user)
            ->save();

        Notification::make()
            ->title(__('pages/auth/register.notifications.registered'))
            ->success()
            ->send();

        Auth::login($user);

        $this->redirect(route('home'));
    }

    public function mount(): void
    {
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
        return view('livewire.auth.register')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.register'),
        ]);
    }
}
