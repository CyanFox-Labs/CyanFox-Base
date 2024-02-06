<?php

namespace App\Livewire\Admin\Notifications;

use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.notifications.notifications')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.notifications.notifications')]);
    }
}
