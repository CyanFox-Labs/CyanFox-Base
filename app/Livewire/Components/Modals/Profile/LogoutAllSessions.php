<?php

namespace App\Livewire\Components\Modals\Profile;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class LogoutAllSessions extends ModalComponent
{

    public $password;

    public function logoutAllSessions()
    {
        try {
            Auth::logoutOtherDevices($this->password);
            Notification::make()
                ->title(__('pages/account/messages.notifications.revoked_all_sessions'))
                ->success()
                ->send();
            $this->redirect(route('profile'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.components.modals.profile.logout-all-sessions');
    }
}
