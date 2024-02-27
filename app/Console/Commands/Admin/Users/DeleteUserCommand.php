<?php

namespace App\Console\Commands\Admin\Users;

use App\Facades\UserManager;
use Illuminate\Console\Command;

class DeleteUserCommand extends Command
{
    protected $signature = 'c:admin:users.delete {username}';

    protected $description = 'Delete a user.';

    public function handle(): void
    {

        $user = UserManager::findUserByUsername($this->argument('username'));
        $user->delete();

        $this->info('User deleted successfully.');

    }
}
