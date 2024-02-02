<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateUser extends Component
{
    public $userId;
    public $user;

    public $firstName;
    public $lastName;
    public $username;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $forceChangePassword = false;
    public $forceActivateTwoFactor = false;
    public $disabled = false;


    public $groups = [];
    public $permissions = [];
    public $selectedGroups = [];
    public $selectedPermissions = [];

    public function updateUser()
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . $this->userId,
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => ['nullable', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'nullable|max:255|same:password',
            'selectedGroups' => 'nullable|array',
            'selectedPermissions' => 'nullable|array',
            'forceChangePassword' => 'nullable|boolean',
            'forceActivateTwoFactor' => 'nullable|boolean',
            'disabled' => 'nullable|boolean',
        ]);

        $this->user->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'force_change_password' => $this->forceChangePassword,
            'force_activate_two_factor' => $this->forceActivateTwoFactor,
            'disabled' => $this->disabled,
        ]);

        if ($this->password) {
            $this->user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $this->user->syncRoles($this->selectedGroups);
        $this->user->syncPermissions($this->selectedPermissions);

        Notification::make()
            ->title(__('pages/admin/users/update_user.notifications.user_updated'))
            ->success()
            ->send();

        return redirect()->route('admin.users');
    }

    public function mount()
    {
        try {
            $this->user = User::findOrFail($this->userId);
        }catch (Exception) {
            abort(404);
        }

        $this->firstName = $this->user->first_name;
        $this->lastName = $this->user->last_name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->forceChangePassword = (bool) $this->user->force_change_password;
        $this->forceActivateTwoFactor = (bool) $this->user->force_activate_two_factor;
        $this->disabled = (bool) $this->user->disabled;

        $this->groups = Role::all()->pluck('name', 'name')->toArray();
        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();

        $this->selectedGroups = $this->user->roles->pluck('name')->toArray();
        $this->selectedPermissions = $this->user->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.users.update-user')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.users.update_user', ['user' => $this->user->username])]);
    }
}
