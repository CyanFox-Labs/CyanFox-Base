<?php

namespace App\Livewire\Components\Modals\Profile;

use LivewireUI\Modal\ModalComponent;

class NewApiKey extends ModalComponent
{

    public $name;
    public $plainTextToken;

    public function createAPIKey()
    {

        $this->validate([
            'name' => 'required',
        ]);

        $token = auth()->user()->createToken($this->name)->plainTextToken;

        $this->plainTextToken = $token;

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.api_key_created');
    }

    public function render()
    {
        return view('livewire.components.modals.profile.new-api-key');
    }
}
