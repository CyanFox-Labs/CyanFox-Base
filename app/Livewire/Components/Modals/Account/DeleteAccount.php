<?php

namespace App\Livewire\Components\Modals\Account;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DeleteAccount extends ModalComponent
{
    public $user;

    public $password;

    public $twoFactorCode;

    public function deleteAccount(): void
    {
        if (Hash::make($this->password, $this->user->password)) {
            if (UserManager::getUser($this->user)->getTwoFactorManager()->isTwoFactorEnabled()) {
                if (!UserManager::getUser($this->user)->getTwoFactorManager()->checkTwoFactorCode($this->twoFactorCode, false)) {
                    throw ValidationException::withMessages([
                        'twoFactorCode' => __('validation.custom.invalid_two_factor_code'),
                    ]);
                }
            }

            try {
                Storage::disk('public')->delete('profile-images/'.$this->user->id.'.png');

                $this->user->delete();
            } catch (Exception $e) {
                Notification::make()
                    ->title(__('messages.notifications.something_went_wrong'))
                    ->danger()
                    ->send();

                $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

                return;
            }

            ActivityLogManager::logName('account')
                ->description('account:delete')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            Notification::make()
                ->title(__('account/profile.modals.delete_account.notifications.account_deleted'))
                ->success()
                ->send();

            $this->closeModal();
            $this->dispatch('refresh');
        } else {
            throw ValidationException::withMessages([
                'password' => __('validation.current_password'),
            ]);
        }
    }

    public function mount(): void
    {
        $this->authorize('canDeleteAccount');

        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.delete-account');
    }
}
