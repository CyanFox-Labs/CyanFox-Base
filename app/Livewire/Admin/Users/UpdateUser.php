<?php

namespace App\Livewire\Admin\Users;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
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

    public function updateUser(): void
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,'.$this->userId,
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'password' => ['nullable', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'nullable|max:255|same:password',
            'selectedGroups' => 'nullable|array',
            'selectedPermissions' => 'nullable|array',
            'forceChangePassword' => 'nullable|boolean',
            'forceActivateTwoFactor' => 'nullable|boolean',
            'disabled' => 'nullable|boolean',
        ]);

        if ($this->user->two_factor_enabled) {
            $this->forceActivateTwoFactor = false;
        }

        try {
            $this->user->update([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
                'force_change_password' => $this->forceChangePassword,
                'force_activate_two_factor' => $this->forceActivateTwoFactor,
                'disabled' => $this->disabled,
                'password' => $this->password ? Hash::make($this->password) : $this->user->password,
            ]);

            $this->user->syncRoles($this->selectedGroups);
            $this->user->syncPermissions($this->selectedPermissions);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('admin')
            ->description('admin:users.update')
            ->causer(Auth::user()->username)
            ->subject($this->user->username)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/users.update.notifications.user_updated'))
            ->success()
            ->send();

        $this->redirect(route('admin.users'), navigate: true);
    }

    public function mount(): void
    {
        $this->user = UserManager::findUser($this->userId);

        if (!$this->user) {
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

        $this->selectedGroups = UserManager::getUser($this->user)->getGroups();
        $this->selectedPermissions = UserManager::getUser($this->user)->getPermissions();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.users.update-user')
            ->layout('components.layouts.admin', ['title' => __('admin/users.update.tab_title', ['user' => $this->user->username])]);
    }
}
