<?php

namespace App\Livewire\Admin\Roles;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleCreate extends Component
{

    public $name;
    public $guard_name;
    public $permissions;

    #[On('updateMultiSelect')]
    public function updateMultiSelect($values): void
    {
        $this->permissions = $values;
    }

    public function createRole()
    {
        $this->validate([
            'name' => 'required|string',
            'guard_name' => 'required|string',
        ]);

        try {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);

            $role->syncPermissions($this->permissions);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }


        Notification::make()
            ->title(__('pages/admin/roles/messages.notifications.created'))
            ->success()
            ->send();

        activity('system')
            ->causedBy(auth()->user())
            ->withProperty('name', $role->name . ' (' . $role->guard_name . ')')
            ->withProperty('ip', session()->get('ip_address'))
            ->log('group.created');

        return redirect()->route('admin-role-list');

    }

    public function mount()
    {
        $this->guard_name = 'web';
    }

    public function render()
    {
        return view('livewire.admin.roles.role-create')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.roles.create')
            ]);
    }
}
