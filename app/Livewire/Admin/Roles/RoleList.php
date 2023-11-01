<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;

class RoleList extends Component
{
    public function render()
    {
        return view('livewire.admin.roles.role-list')
            ->layout('components.layouts.admin', [
                'title' => __('titles.admin.groups')
            ]);
    }
}
