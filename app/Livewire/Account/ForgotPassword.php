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

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|string',
            'password_confirm' => 'required|string',
        ]);

        if ($this->password != $this->password_confirm) {
            throw ValidationException::withMessages([
                'password' => __('validation.custom.passwords_not_match'),
                'password_confirm' => __('validation.custom.passwords_not_match'),
            ]);
        }

        $user = User::where('password_reset_token', $this->resetToken)->first();
        $user->password = Hash::make($this->password);
        $user->password_reset_token = null;
        $user->save();

        Notification::make()
            ->title(__('pages/account/messages.notifications.password_resetted'))
            ->success()
            ->send();

        $this->redirect(route('login'));
    }

    public function sendLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $this->email)->first();

        if ($user == null) {
            throw ValidationException::withMessages([
                'email' => __('pages/account/forgot-password.email_not_found'),
            ]);
        }

        $user->password_reset_token = bin2hex(random_bytes(32));
        $user->save();

        Mail::send('emails.forgot-password', ['resetLink' => route('forgot-password', [$user->password_reset_token])], function ($message) use ($user) {
            $message->to($user->email, __('pages/account/forgot-password.email_content.title'))
                ->subject(__('pages/account/forgot-password.email_content.title'));
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        Notification::make()
            ->title(__('pages/account/messages.notifications.password_reset_link_sent'))
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.account.forgot-password')
            ->layout('components.layouts.guest', [
                'title' => __('navigation/titles.forgot_password')
            ]);
    }
}
