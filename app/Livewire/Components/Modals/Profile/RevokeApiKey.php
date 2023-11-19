<?php

namespace App\Livewire\Components\Modals\Profile;

use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;

class RevokeApiKey extends ModalComponent
{

    public $apiKey;

    public function revokeApiKey()
    {
        auth()->user()->tokens()->where('id', $this->apiKey)->delete();

        Notification::make()
            ->title(__('pages/account/messages.notifications.api_key_revoked'))
            ->success()
            ->send();

        $this->closeModal();
        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.components.modals.profile.revoke-api-key');
    }
}
