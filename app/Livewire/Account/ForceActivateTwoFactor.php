<?php

namespace App\Livewire\Account;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Facades\Utils\UnsplashManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ForceActivateTwoFactor extends Component
{
    #[Url]
    public $redirect;

    public $unsplash;

    public $twoFactorCode;

    public $password;

    public $user;

    public function activateTwoFactor(): void
    {

        if (!Hash::check($this->password, $this->user->password)) {
            ActivityLogManager::logName('account')
                ->description('account:force.activate_two_factor.failed')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        if (!UserManager::getUser($this->user)->getTwoFactorManager()->checkTwoFactorCode($this->twoFactorCode, false)) {
            ActivityLogManager::logName('account')
                ->description('account:force.activate_two_factor.failed')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            throw ValidationException::withMessages([
                'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
            ]);
        }

        try {
            $this->user->update([
                'two_factor_enabled' => true,
                'force_activate_two_factor' => false,
            ]);

            UserManager::getUser($this->user)->getTwoFactorManager()->generateRecoveryCodes();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        ActivityLogManager::logName('account')
            ->description('account:force.activate_two_factor.success')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/force_activate.force_activate_two_factor.notifications.two_factor_enabled'))
            ->success()
            ->send();

        if ($this->redirect) {
            $this->redirect($this->redirect);

            return;
        }

        $this->redirect(route('home'));
    }

    public function mount(): void
    {
        $unsplash = UnsplashManager::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }

        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.force-activate-two-factor')
            ->layout('components.layouts.guest', ['title' => __('account/force_activate.force_activate_two_factor.tab_title')]);
    }
}
