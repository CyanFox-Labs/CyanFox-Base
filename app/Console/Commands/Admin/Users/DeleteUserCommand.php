<?php

namespace App\Console\Commands\Admin\Users;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class DeleteUserCommand extends Command
{
    protected $signature = 'c:admin:users.delete {username}';

    protected $description = 'Delete a user.';

    public function handle(): void
    {


        $user = User::where('username', $this->argument('username'))->first();
        $user->delete();

        $this->info('User deleted successfully.');

    }
}
