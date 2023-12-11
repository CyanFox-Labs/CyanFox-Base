<?php

namespace App\Livewire\Components\Modals\Account;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DisableTwoFactor extends ModalComponent
{
    public $password;

    public function disableTwoFactor()
    {

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $this->password])) {

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.disable_two_factor_failed');


            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }

        Auth::user()->two_factor_enabled = false;

        try {
            Auth::user()->save();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.disable_two_factor_failed');

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        Notification::make()
            ->title(__('pages/account/messages.notifications.two_factor_disabled'))
            ->success()
            ->send();

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.disable_two_factor_success');

        $this->redirect(route('profile'));
    }

    public function render()
    {
        return view('livewire.components.modals.account.disable-two-factor');
    }
}
