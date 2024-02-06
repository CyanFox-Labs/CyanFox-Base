<?php

namespace App\Livewire\Admin\Groups;

use Livewire\Attributes\On;
use Livewire\Component;

class Groups extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.groups.groups')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.groups.groups')]);
    }
}
