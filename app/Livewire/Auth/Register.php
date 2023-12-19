<?php

namespace App\Livewire\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
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
    public $captcha;


    public function setLanguage($language)
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('messages.notifications.language_changed'))
            ->success()
            ->send();
        return redirect()->route('register');
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


        if (env('ENABLE_CAPTCHA')) {
            $validator = Validator::make(['captcha' => $this->captcha], ['captcha' => 'required|captcha']);

            if ($validator->fails()) {
                activity('system')
                    ->causedByAnonymous()
                    ->withProperty('name', $this->username . ' (' . $this->email . ')')
                    ->withProperty('ip', request()->ip())
                    ->log('auth.register_failed');

                Notification::make()
                    ->title(__('validation.custom.invalid_captcha'))
                    ->danger()
                    ->send();

                return;
            }
        }

        if ($this->password != $this->password_confirm) {

            activity('system')
                ->causedByAnonymous()
                ->withProperty('name', $this->username . ' (' . $this->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('auth.register_failed');

            throw ValidationException::withMessages([
                'password' => __('validation.custom.passwords_not_match'),
                'password_confirm' => __('validation.custom.passwords_not_match'),
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

            activity('system')
                ->causedByAnonymous()
                ->withProperty('name', $this->username . ' (' . $this->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('auth.register_failed');


            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        Notification::make()
            ->title(__('pages/auth/messages.notifications.registration_successful'))
            ->success()
            ->send();


        activity('system')
            ->causedByAnonymous()
            ->withProperty('name', $this->username . ' (' . $this->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('auth.register');


        $this->redirect(route('login'));

    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest', [
                'title' => __('pages/auth/messages.buttons.register')
            ]);
    }
}
