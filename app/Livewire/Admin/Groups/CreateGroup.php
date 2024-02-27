<?php

namespace App\Livewire\Admin\Groups;

use App\Facades\ActivityLogManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateGroup extends Component
{
    public $name;

    public $guardName = 'web';

    public $permissions = [];

    public $selectedPermissions = [];

    public function createGroup(): void
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name',
            'guardName' => 'required|string',
        ]);

        try {
            $group = Role::create([
                'name' => $this->name,
                'guard_name' => $this->guardName,
            ]);

            $group->syncPermissions($this->selectedPermissions);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
            ->description('admin:groups.create')
            ->causer(Auth::user()->username)
            ->subject($group->name)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('pages/admin/groups/create_group.notifications.group_created'))
            ->success()
            ->send();

        $this->redirect(route('admin.groups'), navigate: true);
    }

    public function mount(): void
    {
        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.groups.create-group')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.groups.create_group')]);
    }
}
