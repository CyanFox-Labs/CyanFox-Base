<?php

namespace App\Livewire\Installer;

use App\Helpers\UnsplashHelper;
use App\Models\Setting;
use App\Models\User;
use App\Rules\Password;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

    public function registerUser()
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        $user = User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->generateTwoFactorSecret();

        try {
            $user->assignRole('Super Admin');
        } catch (RoleDoesNotExist) {
            $role = Role::create(['name' => 'Super Admin']);
            $user->assignRole($role);
            return;
        }

        Setting::where('key', 'app_installed')->update(['value' => 1]);

        $this->redirect(route('home'));
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.installer.create-user');
    }
}
