<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        return view('livewire.admin.users.users')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.users.users')]);
    }
}
