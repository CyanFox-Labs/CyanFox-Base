<?php

namespace App\Livewire\Components\Modals\Profile;

use Livewire\Component;

class Logout extends Component
{

    public $modalData = 'test';

    protected $listeners = ['open-modal' => 'open'];

    public function open($data)
    {
        $this->modalData = $data['data'];
    }

    public function render()
    {
        return view('livewire.components.modals.profile.logout');
    }
}
