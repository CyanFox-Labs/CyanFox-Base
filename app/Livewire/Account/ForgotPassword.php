<?php

namespace App\Livewire\Account;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
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

        $user = User::where('password_reset_token', $this->resetToken)->first();

        if ($this->password != $this->password_confirm) {
            activity('system')
                ->performedOn($user)
                ->causedByAnonymous()
                ->withProperty('name', $user->username . ' (' . $user->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.forgot_password_failed');
            throw ValidationException::withMessages([
                'password' => __('validation.custom.passwords_not_match'),
                'password_confirm' => __('validation.custom.passwords_not_match'),
            ]);
        }


        $expirationDate = Carbon::parse($user->password_reset_expiration);

        if ($expirationDate->isPast()) {
            Notification::make()
                ->title(__('pages/account/messages.notifications.password_reset_link_expired'))
                ->danger()
                ->send();

            activity('system')
                ->performedOn($user)
                ->causedByAnonymous()
                ->withProperty('name', $user->username . ' (' . $user->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.forgot_password_failed');

            return redirect(route('forgot-password', [""]));
        } else {
            $user->password = Hash::make($this->password);
            $user->password_reset_token = null;
            $user->password_reset_expiration = null;
            $user->save();

            Notification::make()
                ->title(__('pages/account/messages.notifications.password_resetted'))
                ->success()
                ->send();

            activity('system')
                ->performedOn($user)
                ->causedByAnonymous()
                ->withProperty('name', $user->username . ' (' . $user->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.forgot_password_success');

            $this->redirect(route('login'));
        }
    }

    public function sendLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $this->email)->first();

        if ($user == null) {
            activity('system')
                ->performedOn($user)
                ->causedByAnonymous()
                ->withProperty('name', $this->email)
                ->withProperty('ip', request()->ip())
                ->log('account.forgot_password_request_failed');
            throw ValidationException::withMessages([
                'email' => __('pages/account/forgot-password.email_not_found'),
            ]);
        }

        $user->password_reset_token = bin2hex(random_bytes(32));
        $user->password_reset_expiration = Carbon::now()->addHours(24);
        $user->save();

        $placeholders = ['username' => $user->username,
            'first_name' => $user->first_name, 'last_name' => $user->last_name, 'password_reset_token' => $user->password_reset_token,
            'reset_link' => route('forgot-password', [$user->password_reset_token])];

        Mail::send('emails.forgot-password', $placeholders, function ($message) use ($user, $placeholders) {
            $message->to($user->email, __('emails.forgot_password.title', $placeholders))
                ->subject(__('emails.forgot_password.subject', $placeholders));
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        Notification::make()
            ->title(__('pages/account/messages.notifications.password_reset_link_sent'))
            ->success()
            ->send();

        activity('system')
            ->performedOn($user)
            ->causedByAnonymous()
            ->withProperty('name', $user->username . ' (' . $user->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.forgot_password_requested');
    }

    public function mount()
    {
        if ($this->resetToken !== null) {
            $user = User::where('password_reset_token', $this->resetToken)->first();

            if ($user == null) {
                Notification::make()
                    ->title(__('pages/account/messages.notifications.password_reset_link_invalid'))
                    ->danger()
                    ->send();

                return redirect(route('forgot-password', [""]));
            }

            $expirationDate = Carbon::parse($user->password_reset_expiration);

            if ($expirationDate->isPast()) {
                Notification::make()
                    ->title(__('pages/account/messages.notifications.password_reset_link_expired'))
                    ->danger()
                    ->send();

                return redirect(route('forgot-password', [""]));
            }
        }
    }

    public function render()
    {
        return view('livewire.account.forgot-password')
            ->layout('components.layouts.guest', [
                'title' => __('navigation/titles.forgot_password')
            ]);
    }
}
