<?php

namespace App\Livewire\Admin\Users;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Logger;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class UserCreate extends Component
{

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $roles = [];
    public $change_password;
    public $activate_two_factor;

    #[On('updateMultiSelect')]
    public function updateMultiSelect($values): void
    {
        $this->roles = $values;
    }

    public function createUser() {
        try {
            $this->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'username' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'change_password' => 'required|boolean',
                'activate_two_factor' => 'required|boolean',
            ]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            Notification::make()
                ->title(__('messages.fill_all_fields_correctly'))
                ->danger()
                ->send();
            return;
        }

        $userExists = User::where('username', $this->username)->orWhere('email', $this->email)->first();
        if ($userExists != null) {
            Notification::make()
                ->title(__('pages/admin/users/user-create.user_already_exists'))
                ->danger()
                ->send();
            return;
        }


        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->change_password = $this->change_password;
        $user->activate_two_factor = $this->activate_two_factor;

        try {
            $user->save();
        }catch (Exception $e) {
            Log::error($e->getMessage());
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();
            return;
        }

        $authController = new AuthController();
        $authController->generateTwoFactorSecret($user);

        if ($this->roles != null) {
            $user->assignRole($this->roles);
        }

        Notification::make()
            ->title(__('pages/admin/users/user-create.created'))
            ->success()
            ->send();

        return redirect()->route('admin-user-list');
    }

    public function render()
    {
        return view('livewire.admin.users.user-create')
            ->layout('components.layouts.admin', [
                'title' => __('titles.admin.users.create')
            ]);
    }
}
