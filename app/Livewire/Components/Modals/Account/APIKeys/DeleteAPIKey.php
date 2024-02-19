<?php

namespace App\Livewire\Components\Modals\Account\APIKeys;

use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class DeleteAPIKey extends ModalComponent
{

    public $apiKeyId;

    public function deleteAPIKey()
    {
        auth()->user()->tokens()->where('id', $this->apiKeyId)->delete();

        Notification::make()
            ->title(__('components/modals/account/api_keys.delete_api_key.notifications.api_key_deleted'))
            ->success()
            ->send();

        activity()
            ->logName('account')
            ->logMessage('account:api_keys.delete')
            ->causer(auth()->user()->username)
            ->subject(auth()->user()->username)
            ->performedBy(auth()->user()->id)
            ->save();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.a-p-i-keys.delete-a-p-i-key');
    }
}
