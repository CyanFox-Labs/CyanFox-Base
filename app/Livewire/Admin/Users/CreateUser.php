<?php

namespace App\Livewire\Admin\Users;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Models\User;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $firstName;

    public $lastName;

    public $username;

    public $email;

    public $password;

    public $passwordConfirmation;

    public $forceChangePassword = false;

    public $forceActivateTwoFactor = false;

    public $disabled = false;

    public $sendWelcomeEmail = false;

    public $groups = [];

    public $permissions = [];

    public $selectedGroups = [];

    public $selectedPermissions = [];

    public function createUser(): void
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required|max:255|same:password',
            'selectedGroups' => 'nullable|array',
            'selectedPermissions' => 'nullable|array',
            'sendWelcomeEmail' => 'nullable|boolean',
            'forceChangePassword' => 'nullable|boolean',
            'forceActivateTwoFactor' => 'nullable|boolean',
            'disabled' => 'nullable|boolean',
        ]);

        try {
            $user = User::create([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'force_change_password' => $this->forceChangePassword,
                'force_activate_two_factor' => $this->forceActivateTwoFactor,
                'disabled' => $this->disabled,
            ]);

            $user->syncRoles($this->selectedGroups);
            $user->syncPermissions($this->selectedPermissions);
            UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        if ($this->sendWelcomeEmail) {
            $placeholders = ['username' => $this->username,
                'firstName' => $this->firstName, 'lastName' => $this->lastName,
                'password' => $this->password,
                'appName' => setting('app_name'),
                'loginLink' => route('auth.login')];

            Mail::send('emails.welcome', $placeholders, function ($message) use ($user) {
                $message->to($user->email, str_replace(
                    ['{username}', '{firstName}', '{lastName}', '{password}', '{appName}'],
                    [$this->username, $this->firstName, $this->lastName, $this->password, setting('app_name')],
                    setting('emails_welcome_title')
                ))
                    ->subject(str_replace(
                        ['{username}', '{firstName}', '{lastName}', '{password}', '{appName}'],
                        [$this->username, $this->firstName, $this->lastName, $this->password, setting('app_name')],
                        setting('emails_welcome_subject')
                    ));
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
        }

        ActivityLogManager::logName('admin')
            ->description('admin:users.create')
            ->causer(Auth::user()->username)
            ->subject($user->username)
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->title(__('admin/users.create.notifications.user_created'))
            ->success()
            ->send();

        $this->redirect(route('admin.users'), navigate: true);
    }

    public function mount(): void
    {
        $this->groups = Role::all()->pluck('name', 'name')->toArray();
        $this->permissions = Permission::all()->pluck('name', 'name')->toArray();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.users.create-user')
            ->layout('components.layouts.admin', ['title' => __('admin/users.create.tab_title')]);
    }
}
