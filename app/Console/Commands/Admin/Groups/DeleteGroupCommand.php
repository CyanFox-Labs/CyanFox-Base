<?php

namespace App\Console\Commands\Admin\Groups;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class DeleteGroupCommand extends Command
{
    protected $signature = 'c:admin:groups.delete {name}';

    protected $description = 'Delete a group.';

    public function handle(): void
    {


        $group = Role::where('name', $this->argument('name'))->first();
        $group->delete();

        $this->info('Group deleted successfully.');

    }
}
