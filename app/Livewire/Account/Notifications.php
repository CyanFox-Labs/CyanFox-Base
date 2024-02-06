<?php

namespace App\Livewire\Account;

use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.notifications')
            ->layout('components.layouts.app', ['title' => __('navigation/titles.notifications')]);
    }
}
