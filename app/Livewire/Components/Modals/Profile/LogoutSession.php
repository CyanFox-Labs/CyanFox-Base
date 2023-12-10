<?php

namespace App\Livewire\Components\Modals\Profile;

use App\Http\Controllers\Auth\AuthController;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class LogoutSession extends ModalComponent
{
    public $sessionId;
    public $password;

    public function logoutSession()
    {
        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.revoke_session_failed');

            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }

        AuthController::regenerateRememberToken(Auth::user());
        DB::table('sessions')->where('id', $this->sessionId)->delete();
        Notification::make()
            ->title(__('pages/account/messages.notifications.session_revoked'))
            ->success()
            ->send();

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.revoke_session_success');

        $this->redirect(route('profile'));
    }

    public function render()
    {
        return view('livewire.components.modals.profile.logout-session');
    }
}
