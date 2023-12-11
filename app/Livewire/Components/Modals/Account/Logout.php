<?php

namespace App\Livewire\Components\Modals\Account;

use LivewireUI\Modal\ModalComponent;

class Logout extends ModalComponent
{
    public function render()
    {
        return view('livewire.components.modals.account.logout');
    }
}
