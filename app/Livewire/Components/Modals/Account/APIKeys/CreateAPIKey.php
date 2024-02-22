<?php

namespace App\Livewire\Components\Modals\Account\APIKeys;

use App\Facades\UserManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class CreateAPIKey extends ModalComponent
{
    public $name;
    public $plainTextToken;
    public $user;

    public function createAPIKey()
    {
        $this->validate([
            'name' => 'required|unique:personal_access_tokens,name'
        ]);

        $this->plainTextToken = UserManager::getUser($this->user)->getAPIKeyManager()->createAPIKey($this->name);

        activity()
            ->logName('account')
            ->description('account:api_keys.create')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/api_keys.create_api_key.notifications.api_key_created'))
            ->success()
            ->send();
    }

    public function close()
    {
        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.components.modals.account.a-p-i-keys.create-a-p-i-key');
    }
}
