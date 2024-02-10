<?php

namespace App\Livewire\Auth;

use App\Helpers\UnsplashHelper;
use App\Models\User;
use App\Rules\Password;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
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

    public function mount()
    {
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

    public function register()
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
                    'captcha' => __('validation.custom.invalid_captcha')
                ]);
            }
        }

        $user = User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->generateTwoFactorSecret();

        Notification::make()
            ->title(__('pages/auth/register.notifications.registered'))
            ->success()
            ->send();

        Auth::login($user);

        $this->redirect(route('home'));
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.guest', [
            'title' => __('navigation/titles.register')
        ]);
    }
}
