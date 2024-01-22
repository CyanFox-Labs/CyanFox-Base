<?php

namespace App\Livewire\Components\Modals\Account\APIKeys;

use Filament\Notifications\Notification;
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

        return redirect()->route('account.profile', ['tab' => 'apiKeys']);
    }

    public function render()
    {
        return view('livewire.components.modals.account.a-p-i-keys.delete-a-p-i-key');
    }
}
