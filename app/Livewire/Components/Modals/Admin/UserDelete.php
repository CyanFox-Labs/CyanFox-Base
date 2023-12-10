<?php

namespace App\Livewire\Components\Modals\Admin;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;

class UserDelete extends ModalComponent
{
    public $userId;

    public function deleteUser()
    {
        $user = User::find($this->userId);

        $user->delete();

        Notification::make()
            ->title(__('pages/admin/users/messages.notifications.deleted'))
            ->success()
            ->send();

        activity('system')
            ->causedBy(auth()->user())
            ->withProperty('name', $user->username . ' (' . $user->email . ')')
            ->withProperty('ip', session()->get('ip_address'))
            ->log('user.deleted');

        return redirect()->route('admin-user-list');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.user-delete');
    }
}
