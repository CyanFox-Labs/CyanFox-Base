<?php

namespace App\Livewire\Components\Modals\Account;

use Filament\Notifications\Notification;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use LivewireUI\Modal\ModalComponent;

class SetupPassword extends ModalComponent
{

    public $newPassword;
    public $passwordConfirmation;

    public function setupPassword() {
        $this->validate([
            'newPassword' => 'required|max:255|same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->newPassword),
        ]);

        DB::table('sessions')
            ->where('user_id', Auth::user()->id)
            ->whereNotIn('id', [Session::getId()])
            ->delete();


        Notification::make()
            ->title(__('components/modals/account/setup_password.notifications.password_updated'))
            ->success()
            ->send();

        return redirect()->route('account.profile');
    }

    public function render()
    {
        return view('livewire.components.modals.account.setup-password');
    }
}
