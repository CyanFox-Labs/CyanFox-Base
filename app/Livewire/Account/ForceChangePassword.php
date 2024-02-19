<?php

namespace App\Livewire\Account;

use App\Helpers\UnsplashHelper;
use App\Rules\Password;
use Filament\Notifications\Notification;
use Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ForceChangePassword extends Component
{
    #[Url]
    public $redirect;
    public $unsplash;

    public $currentPassword;
    public $newPassword;
    public $newPasswordConfirmation;

    public function mount()
    {
        $unsplash = UnsplashHelper::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }
    }

    public function changePassword()
    {
        $this->validate([
            'currentPassword' => 'required|max:255',
            'newPassword' => ['required', 'max:255', 'same:newPasswordConfirmation', new Password],
            'newPasswordConfirmation' => 'required',
        ]);

        if (!Hash::check($this->currentPassword, auth()->user()->password)) {
            activity()
                ->logName('account')
                ->logMessage('account:force.change_password.failed')
                ->causer(auth()->user()->username)
                ->subject(auth()->user()->username)
                ->performedBy(auth()->user()->id)
                ->save();

            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($this->newPassword),
            'force_change_password' => false,
        ]);

        activity()
            ->logName('account')
            ->logMessage('account:force.change_password.success')
            ->causer(auth()->user()->username)
            ->subject(auth()->user()->username)
            ->performedBy(auth()->user()->id)
            ->save();

        Notification::make()
            ->success()
            ->title(__('pages/account/force_change_password.notifications.password_changed'))
            ->send();

        if ($this->redirect) {
            return redirect()->to($this->redirect);
        }

        $this->redirect(route('home'), navigate: true);
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.force-change-password')->layout('components.layouts.guest', ['title' => __('navigation/titles.force_change_password')]);
    }
}
