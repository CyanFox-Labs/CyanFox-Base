<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\UserManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DeleteAccount extends ModalComponent
{

    public $user;
    public $password;
    public $twoFactorCode;

    public function deleteAccount()
    {

        if (!Auth::validate(['email' => $this->user->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password')
            ]);
        }

        if (UserManager::getUser($this->user)->getTwoFactorManager()->isTwoFactorEnabled()) {
            if (!UserManager::getUser($this->user)->getTwoFactorManager()->checkTwoFactorCode($this->twoFactorCode, false)) {
                throw ValidationException::withMessages([
                    'twoFactorCode' => __('validation.custom.invalid_two_factor_code')
                ]);
            }
        }

        Storage::disk('public')->delete('profile-images/' . $this->user->id . '.png');

        UserManager::deleteUser($this->user);

        activity()
            ->logName('account')
            ->description('account:delete')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

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

        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.delete-account');
    }
}
