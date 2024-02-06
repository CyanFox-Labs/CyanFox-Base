<?php

namespace App\Livewire\Components\Modals\Account\APIKeys;

use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;

class CreateAPIKey extends ModalComponent
{
    public $name;

    public function createAPIKey()
    {
        $this->validate([
            'name' => 'required|unique:personal_access_tokens,name'
        ]);

        auth()->user()->createToken($this->name);

        Notification::make()
            ->title(__('components/modals/account/api_keys.create_api_key.notifications.api_key_created'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.components.modals.account.a-p-i-keys.create-a-p-i-key');
    }
}
