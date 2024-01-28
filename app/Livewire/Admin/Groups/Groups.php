<?php

namespace App\Livewire\Admin\Groups;

use Livewire\Component;

class Groups extends Component
{
    public function render()
    {
        return view('livewire.admin.groups.groups')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.groups.groups')]);
    }
}
