<?php

namespace App\Livewire\Components\Modals\Account;

use Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
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

        if (!auth()->user()->checkTwoFactorCode($this->twoFactorCode, false)) {
            throw ValidationException::withMessages([
                'twoFactorCode' => __('validation.custom.invalid_two_factor_code')
            ]);
        }

        Storage::disk('public')->delete('profile-images/' . auth()->user()->id . '.png');

        auth()->user()->delete();

        Notification::make()
            ->title(__('components/modals/account/delete_account.notifications.account_deleted'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function mount()
    {
        if (!setting('profile_enable_delete_account')) {
            abort(403);
        }
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.delete-account');
    }
}
