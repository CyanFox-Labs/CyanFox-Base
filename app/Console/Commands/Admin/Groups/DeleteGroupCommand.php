<?php

namespace App\Console\Commands\Admin\Groups;

use App\Facades\GroupManager;
use Illuminate\Console\Command;

class DeleteGroupCommand extends Command
{
    protected $signature = 'c:admin:groups.delete {name}';

    protected $description = 'Delete a group.';

    public function handle(): void
    {

        $group = GroupManager::findGroupByName($this->argument('name'));

        if (!$group) {
            $this->error('Group not found.');

            return;
        }

        $group->delete();

        $this->info('Group deleted successfully.');

    }
}
