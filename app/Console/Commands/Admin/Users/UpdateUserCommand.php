<?php

namespace App\Console\Commands\Admin\Users;

use App\Facades\UserManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
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
        $user = UserManager::findUserByUsername($this->argument('username'));

        if (!$user) {
            $this->error('User not found.');

            return;
        }

        $username = text(
            'What is the user\'s username?',
            default: $user->username,
            required: true,
        );
        $firstName = text(
            'What is the user\'s first name?',
            default: $user->first_name,
            required: true
        );
        $lastName = text(
            'What is the user\'s last name?',
            default: $user->last_name,
            required: true
        );
        $email = text(
            'What is the user\'s email?',
            default: $user->email,
            required: true,
            validate: fn ($email) => (filter_var($email, FILTER_VALIDATE_EMAIL) !== false ?
                null
                : 'Invalid email.')
        );
        $password = password(
            'What is your password? (Leave empty to keep the current password)'
        );
        $superAdmin = confirm(
            'Do you want to make this user a super admin?',
            default: $user->hasRole('Super Admin')
        );
        $disabled = confirm(
            'Do you want to disable this user?',
            default: $user->disabled === '1'
        );

        $user->update([
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password ? Hash::make($password) : $user->password,
            'disabled' => $disabled ? '1' : '0',
        ]);

        if ($superAdmin) {
            try {
                $user->assignRole('Super Admin');
            } catch (RoleDoesNotExist) {
                $this->warn('Super Admin role does not exist. Creating role...');
                $role = Role::create(['name' => 'Super Admin']);
                $this->info('Role created successfully.');
                $user->assignRole($role);
            }
        } else {
            $user->removeRole('Super Admin');
        }

        $this->info('User updated successfully.');

    }
}
