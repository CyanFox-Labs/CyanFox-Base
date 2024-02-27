<?php

namespace App\Livewire\Account;

use App\Facades\ActivityLogManager;
use App\Facades\Utils\UnsplashManager;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ForceChangePassword extends Component
{
    #[Url]
    public $redirect;

    public $unsplash;

    public $user;

    public $currentPassword;

    public $newPassword;

    public $newPasswordConfirmation;

    public function changePassword(): void
    {
        $this->validate([
            'currentPassword' => 'required|max:255',
            'newPassword' => ['required', 'max:255', 'same:newPasswordConfirmation', new Password],
            'newPasswordConfirmation' => 'required',
        ]);

        if (!Hash::check($this->currentPassword, $this->user->password)) {
            ActivityLogManager::logName('account')
                ->description('account:force.change_password.failed')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        try {
            $this->user->update([
                'password' => Hash::make($this->newPassword),
                'force_change_password' => false,
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('account')
            ->description('account:force.change_password.success')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->success()
            ->title(__('pages/account/force_change_password.notifications.password_changed'))
            ->send();

        if ($this->redirect) {
            redirect()->to($this->redirect);

            return;
        }

        $this->redirect(route('home'), navigate: true);
    }

    public function mount(): void
    {
        $unsplash = UnsplashManager::returnBackground();

        $this->unsplash = $unsplash;

        $this->user = Auth::user();

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.force-change-password')->layout('components.layouts.guest', ['title' => __('navigation/titles.force_change_password')]);
    }
}
