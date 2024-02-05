<?php

namespace App\Livewire\Account;

use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        return view('livewire.account.notifications')
            ->layout('components.layouts.app', ['title' => __('navigation/titles.notifications')]);
    }
}
