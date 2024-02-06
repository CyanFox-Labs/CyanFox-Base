<?php

namespace App\Livewire\Admin\Groups;

use Exception;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateGroup extends Component
{
    public $groupId;
    public $group;

    public $name;
    public $guardName = 'web';

    public $permissions = [];
    public $selectedPermissions = [];

    public function updateGroup()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name,' . $this->groupId . ',id',
            'guardName' => 'required|string',
        ]);

        $this->group->name = $this->name;
        $this->group->guard_name = $this->guardName;
        $this->group->save();

        $this->group->syncPermissions($this->selectedPermissions);

        Notification::make()
            ->title(__('pages/admin/groups/update_group.notifications.group_updated'))
            ->success()
            ->send();

        $this->redirect(route('admin.groups'), navigate: true);
    }

    public function mount()
    {
        try {
            $this->group = Role::findOrFail($this->groupId);
        }catch (Exception) {
            abort(404);
        }

        $this->name = $this->group->name;
        $this->guardName = $this->group->guard_name;
        $this->selectedPermissions = $this->group->permissions->pluck('name')->toArray();

        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.groups.update-group')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.groups.update_group', ['group' => $this->group->name])]);
    }
}
