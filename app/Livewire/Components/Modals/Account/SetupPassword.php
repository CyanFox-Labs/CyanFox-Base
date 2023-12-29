<?php

namespace App\Livewire\Components\Modals\Account;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class SetupPassword extends ModalComponent
{
    public $new_password;
    public $confirm_password;

    public function setupPassword()
    {
        $this->validate([
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);


        if ($this->new_password !== $this->confirm_password) {

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.change_password_failed');

            throw ValidationException::withMessages([
                'new_password' => __('validation.custom.passwords_not_match'),
                'confirm_password' => __('validation.custom.passwords_not_match')
            ]);
        }

        Auth::user()->password = bcrypt($this->new_password);

        try {
            Auth::user()->save();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.change_password_failed');
            return;
        }

        Notification::make()
            ->title(__('pages/account/messages.notifications.password_changed'))
            ->success()
            ->send();

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.change_password_success');

        $this->redirect(route('profile'));
    }

    public function render()
    {
        return view('livewire.components.modals.account.setup-password');
    }
}
