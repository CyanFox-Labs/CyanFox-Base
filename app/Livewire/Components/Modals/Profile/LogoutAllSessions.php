<?php

namespace App\Livewire\Components\Modals\Profile;

use App\Http\Controllers\Auth\AuthController;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class LogoutAllSessions extends ModalComponent
{

    public $password;

    public function logoutAllSessions()
    {
        try {
           // Auth::logoutOtherDevices($this->password); // Idk why this doesn't work anymore
            if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {

                activity('system')
                    ->performedOn(auth()->user())
                    ->causedBy(auth()->user())
                    ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                    ->withProperty('ip', request()->ip())
                    ->log('account.revoke_all_sessions_failed');

                throw ValidationException::withMessages([
                    'password' => __('validation.current_password'),
                ]);
            }

            AuthController::regenerateRememberToken(Auth::user());
            DB::table('sessions')
                ->where('user_id', Auth::user()->id)
                ->whereNotIn('id', [Session::getId()])
                ->delete();

            Notification::make()
                ->title(__('pages/account/messages.notifications.revoked_all_sessions'))
                ->success()
                ->send();

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.revoke_all_sessions_success');

            $this->redirect(route('profile'));
        } catch (Exception $e) {

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.revoke_all_sessions_failed');

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
