<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class UserEdit extends Component
{

    public $userId;
    public $user;

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

    public function updateUser()
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $this->userId,
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'change_password' => 'required|boolean',
            'activate_two_factor' => 'required|boolean',
        ]);


        $user = User::find($this->userId);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        if ($this->password != null) $user->password = Hash::make($this->password);
        $user->change_password = $this->change_password;
        $user->activate_two_factor = $this->activate_two_factor;

        try {
            $user->save();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        if ($this->roles != null) {
            $user->assignRole($this->roles);
        }

        Notification::make()
            ->title(__('pages/admin/users/messages.notifications.updated'))
            ->success()
            ->send();

        return redirect()->route('admin-user-list');
    }

    public function mount()
    {
        $this->user = User::find($this->userId);
        if (!$this->user) {
            abort(404);
        }

        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->change_password = $this->user->change_password;
        $this->activate_two_factor = $this->user->activate_two_factor;

    }

    public function render()
    {
        return view('livewire.admin.users.user-edit')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.users.edit')
            ]);
    }
}
