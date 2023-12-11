<?php

namespace App\Livewire\Components\Modals\Account;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class DeleteAccount extends ModalComponent
{

    public $password;

    public function deleteAccount() {
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

        Auth::user()->delete();

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.delete_account_success');

        Notification::make()
            ->title(__('pages/account/messages.notifications.account_deleted'))
            ->success()
            ->send();

        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.components.modals.account.delete-account');
    }
}
