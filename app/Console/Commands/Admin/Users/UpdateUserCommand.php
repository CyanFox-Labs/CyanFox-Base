<?php

namespace App\Console\Commands\Admin\Users;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class UpdateUserCommand extends Command
{
    protected $signature = 'c:admin:users.update {username}';

    protected $description = 'Update a user.';

    public function handle(): void
    {

        $username = text(
            'What is the user\'s username?',
            required: true,
        );
        $first_name = text(
            'What is the user\'s first name?',
            required: true
        );
        $last_name = text(
            'What is the user\'s last name?',
            required: true
        );
        $email = text(
            'What is the user\'s email?',
            required: true,
            validate: fn($email) =>
            (filter_var($email, FILTER_VALIDATE_EMAIL) !== false ?
                null
                : 'Invalid email.')
        );
        $password = password(
            'What is your password?'
        );
        $super_admin = confirm(
            'Do you want to make this user a super admin?',
            default: false
        );

        $user = User::where('username', $this->argument('username'))->first();
        $user->username = $username;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        if ($password) {
            $user->password = bcrypt($password);
        }
        $user->save();

        if ($super_admin) {
            try {
                $user->assignRole('Super Admin');
            } catch (RoleDoesNotExist $e) {
                $this->warn('Super Admin role does not exist. Creating role...');
                $role = Role::create(['name' => 'Super Admin']);
                $this->info('Role created successfully.');
                $user->assignRole($role);
                return;
            }
        }else {
            $user->removeRole('Super Admin');
        }

        $this->info('User updated successfully.');

    }
}
