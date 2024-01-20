<?php

namespace App\Livewire\Components\Modals\Account;

use Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class DeleteAccount extends ModalComponent
{

    public $password;
    public $twoFactorCode;

    public function deleteAccount()
    {

        if (!Auth::validate(['email' => auth()->user()->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        if(!auth()->user()->checkTwoFactorCode($this->twoFactorCode, false)) {
            throw ValidationException::withMessages([
                'twoFactorCode' => __('validation.custom.invalid_two_factor_code')
            ]);
        }

        auth()->user()->delete();

        Notification::make()
            ->title(__('components/modals/account/delete_account.notifications.account_deleted'))
            ->success()
            ->send();

        return redirect()->route('auth.login');
    }

    public function mount()
    {
        if (!setting('enable_delete_account')) {
            abort(403);
        }

    }

    public function render()
    {
        return view('livewire.components.modals.account.delete-account');
    }
}
