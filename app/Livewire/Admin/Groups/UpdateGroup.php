<?php

namespace App\Livewire\Admin\Groups;

use App\Facades\ActivityLogManager;
use App\Facades\GroupManager;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class UpdateGroup extends Component
{
    public $groupId;

    public $group;

    public $name;

    public $guardName = 'web';

    public $permissions = [];

    public $selectedPermissions = [];

    public function updateGroup(): void
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name,'.$this->groupId.',id',
            'guardName' => 'required|string',
        ]);

        try {
            $this->group->update([
                'name' => $this->name,
                'guard_name' => $this->guardName,
            ]);

            $this->group->syncPermissions($this->selectedPermissions);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
            ->description('admin:groups.update')
            ->causer(Auth::user()->username)
            ->subject($this->group->name)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/groups.update.notifications.group_updated'))
            ->success()
            ->send();

        $this->redirect(route('admin.groups'), navigate: true);
    }

    public function mount(): void
    {
        $this->group = GroupManager::findGroup($this->groupId);

        if (!$this->group) {
            abort(404);
        }

        $this->name = $this->group->name;
        $this->guardName = $this->group->guard_name;
        $this->selectedPermissions = GroupManager::getPermissionsFromGroup($this->group);

        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.groups.update-group')
            ->layout('components.layouts.admin', ['title' => __('admin/groups.update.tab_title', ['group' => $this->group->name])]);
    }
}
