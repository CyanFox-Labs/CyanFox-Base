<?php

namespace App\Livewire\Installer;

use App\Facades\SettingsManager;
use App\Facades\UserManager;
use App\Models\User;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $firstName;

    public $lastName;

    public $username;

    public $email;

    public $password;

    public $passwordConfirmation;

    public function registerUser(): void
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        try {
            $user = User::create([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

            UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        try {
            $user->assignRole('Super Admin');
        } catch (RoleDoesNotExist) {
            $role = Role::create(['name' => 'Super Admin']);
            $user->assignRole($role);

            return;
        }

        SettingsManager::updateSetting('app_installed', 1);

        $this->redirect(route('home'));
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.installer.create-user');
    }
}
