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
    }

    public function render()
    {
        return view('livewire.components.modals.profile.new-api-key');
    }
}
