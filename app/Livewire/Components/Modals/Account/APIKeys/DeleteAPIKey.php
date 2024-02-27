<?php

namespace App\Livewire\Components\Modals\Account\APIKeys;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DeleteAPIKey extends ModalComponent
{
    public $apiKeyId;

    public $user;

    public function deleteAPIKey(): void
    {
        try {
            UserManager::getUser($this->user)->getAPIKeyManager()->deleteAPIKey($this->apiKeyId);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        Notification::make()
            ->title(__('components/modals/account/api_keys.delete_api_key.notifications.api_key_deleted'))
            ->success()
            ->send();

        ActivityLogManager::logName('account')
            ->description('account:api_keys.delete')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.a-p-i-keys.delete-a-p-i-key');
    }
}
