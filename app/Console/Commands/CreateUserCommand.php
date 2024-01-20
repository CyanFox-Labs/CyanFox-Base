<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUserCommand extends Command
{
    protected $signature = 'c:make:user';

    protected $description = 'Create a new user';

    public function handle(): void
    {

        $username = text(
            'What is the user\'s username?',
            required: true,
            validate: fn($username) => User::where('username', $username)->exists() ? 'Username already in use.' : null
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
                (User::where('email', $email)->exists() ? 'Email already in use.' : null)
                : 'Invalid email.')
        );
        $password = password(
            'What is your password?'
        );
        $super_admin = confirm(
            'Do you wish to assign this user the SuperAdmin role?',
            default: false
        );

        $user = User::create([
            'username' => $username,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        if ($super_admin) {
            try {
                $user->assignRole('SuperAdmin');
            } catch (RoleDoesNotExist $e) {
                $this->warn('SuperAdmin role does not exist. Creating role...');
                $role = Role::create(['name' => 'SuperAdmin']);
                $this->info('Role created successfully.');
                $user->assignRole($role);
                return;
            }
            $user->assignRole('SuperAdmin');
        }

        try {
            $user->generateTwoFactorSecret();
        }catch (\Exception $exception) {
            $this->error('Something went wrong while generating two factor secret.');
            $this->error($exception->getMessage());
        }

        $this->info('User created successfully.');

    }
}
