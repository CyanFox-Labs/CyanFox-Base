<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogoutAllSessions extends Component
{

    public $password;

    public function logoutAllSessions()
    {
        try {
            Auth::logoutOtherDevices($this->password);
            Notification::make()
                ->title(__('pages/profile.logout_all_sessions.logged_out'))
                ->success()
                ->send();
            $this->redirect(route('profile'));
        } catch (\Exception $e) {
            Notification::make()
                ->title(__('messages.invalid_password'))
                ->danger()
                ->send();
            return;
        }
    }

    public function render()
    {
        return view('livewire.components.modals.profile.logout-all-sessions');
    }
}
