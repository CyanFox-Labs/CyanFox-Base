<?php

namespace App\Livewire\Admin\Users;

use Livewire\Attributes\On;
use Livewire\Component;

class Users extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.users.users')
            ->layout('components.layouts.admin', ['title' => __('admin/users.list.tab_title')]);
    }
}
