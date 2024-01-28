<?php

namespace App\Livewire\Admin\Groups;

use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateGroup extends Component
{
    public $name;
    public $guardName = 'web';

    public $permissions = [];
    public $selectedPermissions = [];

    public function createGroup()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name',
            'guardName' => 'required|string',
        ]);

        $group = Role::create([
            'name' => $this->name,
            'guard_name' => $this->guardName,
        ]);

        $group->syncPermissions($this->selectedPermissions);

        Notification::make()
            ->title(__('pages/admin/groups/create_group.notifications.group_created'))
            ->success()
            ->send();

        return redirect()->route('admin.groups');

    }

    public function mount()
    {
        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.groups.create-group')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.groups.create_group')]);
    }
}
