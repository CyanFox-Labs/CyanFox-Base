<?php

namespace App\Livewire\Admin\Roles;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{

    public $roleId;
    public $role;

    public $name;
    public $guard_name;
    public $permissions;

    #[On('updateMultiSelect')]
    public function updateMultiSelect($values): void
    {
        $this->permissions = $values;
    }

    public function updateRole() {
        try {
            $this->validate([
                'name' => 'required|string',
                'guard_name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            Notification::make()
                ->title(__('messages.fill_all_fields_correctly'))
                ->danger()
                ->send();
            return;
        }

        try {
            $role = Role::find($this->roleId);
            $role->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
            return;
        }

        $role->syncPermissions($this->permissions);

        Notification::make()
            ->title(__('pages/admin/roles/role-edit.updated'))
            ->success()
            ->send();

        return redirect()->route('admin-role-list');
    }

    public function mount() {
        $this->role = Role::find($this->roleId);

        $this->name = $this->role->name;
        $this->guard_name = $this->role->guard_name;
    }

    public function render()
    {
        return view('livewire.admin.roles.role-edit')
            ->layout('components.layouts.admin', [
                'title' => __('titles.admin.groups')
            ]);
    }
}
