<?php

namespace App\Livewire\Components\Modals\Admin;

use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class RoleDelete extends ModalComponent
{

    public $roleId;

    public function deleteRole()
    {
        $role = Role::find($this->roleId);

        $role->delete();

        Notification::make()
            ->title(__('pages/admin/roles/messages.notifications.deleted'))
            ->success()
            ->send();

        activity('system')
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperty('name', $role->name . ' (' . $role->guard_name . ')')
            ->withProperty('ip', request()->ip())
            ->log('group.deleted');

        return redirect()->route('admin-role-list');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.role-delete');
    }
}
