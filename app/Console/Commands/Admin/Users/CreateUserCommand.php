<?php

namespace App\Console\Commands\Admin\Users;

use App\Facades\UserManager;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUserCommand extends Command
{
    protected $signature = 'c:admin:users.create';

    protected $description = 'Create a new user';

    public function handle(): void
    {

        $username = text(
            'What is the user\'s username?',
            required: true,
            validate: fn ($username) => UserManager::findUserByUsername($username) ? 'Username already in use.' : null
        );
        $firstName = text(
            'What is the user\'s first name?',
            required: true
        );
        $lastName = text(
            'What is the user\'s last name?',
            required: true
        );
        $email = text(
            'What is the user\'s email?',
            required: true,
            validate: fn ($email) => (filter_var($email, FILTER_VALIDATE_EMAIL) !== false ?
                (UserManager::findUserByEmail($email) ? 'Email already in use.' : null)
                : 'Invalid email.')
        );
        $password = password(
            'What is your password?'
        );
        $superAdmin = confirm(
            'Do you want to assign this user the Super Admin role?',
            default: false
        );

        $user = User::create([
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
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
        }

        try {
            UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        } catch (Exception $e) {
            $this->error('Something went wrong while generating two factor secret.');
            $this->error($e->getMessage());
        }

        $this->info('User created successfully.');

    }
}
