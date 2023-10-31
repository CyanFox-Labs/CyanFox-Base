<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class UserList extends Component
{
    public function render()
    {
        return view('livewire.admin.users.user-list')
            ->layout('components.layouts.admin', [
                'title' => __('titles.admin.users.list')
            ]);
    }
}
