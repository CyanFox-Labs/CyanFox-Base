<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\HCaptchaValidator;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Register extends Component
{
    use WithRateLimiting;

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $hcaptcha;

    public $rateLimitTime;

    public function setLanguage($language)
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('messages.language_changed'))
            ->success()
            ->send();
        return redirect()->route('register');
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'password_confirm' => 'required|string',
        ]);


        if (env('ENABLE_HCAPTCHA')) {
            try {
                $this->validate(['hcaptcha' => ['required', new HCaptchaValidator()]]);
            } catch (ValidationException $e) {
                Notification::make()
                    ->title(__('messages.invalid_captcha'))
                    ->danger()
                    ->send();
                return;
            }
        }

        if ($this->password != $this->password_confirm) {
            throw ValidationException::withMessages([
                'password' => __('pages/register.password_not_match'),
                'password_confirm' => __('pages/register.password_not_match'),
            ]);
        }

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);

        try {
            $user->save();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
            return;
        }

        Notification::make()
            ->title(__('pages/register.registered'))
            ->success()
            ->send();

        $this->redirect(route('login'));

    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest', [
                'title' => __('titles.register')
            ]);
    }
}
