<?php

namespace App\Console\Commands\Admin\Groups;

use App\Facades\GroupManager;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class UpdateGroupCommand extends Command
{
    protected $signature = 'c:admin:groups.update {name}';

    protected $description = 'Update a group.';

    public function handle(): void
    {
        $role = GroupManager::findGroupByName($this->argument('name'));

        if (!$role) {
            $this->error('Group not found.');

            return;
        }

        $name = text(
            'What is the groups\'s name?',
            required: true,
        );
        $guardName = text(
            'What is the group\'s guard name?',
            placeholder: 'web',
            default: 'web',
            required: true
        );
        $permissions = multiselect(
            label: 'Select the group\'s permissions',
            options: Permission::all()->pluck('name')->toArray(),
        );

        $role->update([
            'name' => $name,
            'guard_name' => $guardName,
        ]);

        $role->syncPermissions($permissions);

        $this->info('Group updated successfully.');
    }
}
