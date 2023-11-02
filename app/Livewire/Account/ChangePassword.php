<?php

namespace App\Livewire\Account;

use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirm;


    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'new_password_confirm' => 'required',
        ]);

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->current_password])) {
            throw ValidationException::withMessages([
                'current_password' => __('validation.current_password'),
            ]);
        }

        if ($this->new_password !== $this->new_password_confirm) {
            throw ValidationException::withMessages([
                'new_password' => __('validation.custom.passwords_not_match'),
                'new_password_confirm' => __('validation.custom.passwords_not_match'),
            ]);
        }

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($this->new_password);
        $user->change_password = 0;

        try {
            $user->save();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        Notification::make()
            ->title(__('pages/account/messages.notifications.password_changed'))
            ->success()
            ->send();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.account.change-password')
            ->layout('components.layouts.guest', [
                'title' => __('pages/account/messages.buttons.change_password'),
            ]);
    }
}
