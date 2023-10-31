<?php

namespace App\Livewire\Account;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ForgotPassword extends Component
{

    public $email;
    public $resetToken;
    public $password;
    public $password_confirm;

    public function resetPassword() {
        try {
            $this->validate([
                'password' => 'required|string',
            ]);
        }catch (ValidationException $e) {
            Notification::make()
                ->title(__('messages.fill_all_fields_correctly'))
                ->danger()
                ->send();
            return;
        }

        if ($this->password != $this->password_confirm) {
            Notification::make()
                ->title(__('pages/account/forgot-password.passwords_not_match'))
                ->danger()
                ->send();
            return;
        }

        $user = User::where('password_reset_token', $this->resetToken)->first();
        $user->password = Hash::make($this->password);
        $user->password_reset_token = null;
        $user->save();

        Notification::make()
            ->title(__('pages/account/forgot-password.password_resetted'))
            ->success()
            ->send();

        $this->redirect(route('login'));
    }

    public function sendLink()
    {
        try {
            $this->validate([
                'email' => 'required|email',
            ]);
        }catch (ValidationException $e) {
            Notification::make()
                ->title(__('messages.fill_all_fields_correctly'))
                ->danger()
                ->send();
            return;
        }

        $user = User::where('email', $this->email)->first();
        $user->password_reset_token = bin2hex(random_bytes(32));
        $user->save();

        Mail::send('emails.forgot-password', [ 'resetLink' => route('forgot-password', [$user->password_reset_token]) ], function ($message) use ($user) {
            $message->to($user->email, __('pages/account/forgot-password.email_content.title'))
                ->subject(__('pages/account/forgot-password.email_content.title'));
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        Notification::make()
            ->title(__('pages/account/forgot-password.email_sent'))
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.account.forgot-password')
            ->layout('components.layouts.guest', [
                'title' => __('titles.forgot_password')
            ]);
    }
}
