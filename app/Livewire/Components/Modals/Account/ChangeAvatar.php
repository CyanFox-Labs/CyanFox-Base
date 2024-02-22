<?php

namespace App\Livewire\Components\Modals\Account;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class ChangeAvatar extends ModalComponent
{
    use WithFileUploads;

    public $avatar;
    public $customAvatarUrl;
    public $user;

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'nullable|image|max:5000',
            'customAvatarUrl' => 'nullable|url',
        ]);

        if ($this->customAvatarUrl) {

            $this->user->update([
                'custom_avatar_url' => $this->customAvatarUrl,
            ]);

            activity()
                ->logName('account')
                ->description('account:avatar.update')
                ->causer($this->user->username)
                ->subject($this->user->username)
                ->performedBy($this->user)
                ->save();

            Notification::make()
                ->title(__('components/modals/account/change_avatar.notifications.avatar_updated'))
                ->success()
                ->send();

            $this->closeModal();
            $this->redirect(route('account.profile'), navigate: true);
            return;
        }

        if (!$this->avatar) {
            Notification::make()
                ->title(__('components/modals/account/change_avatar.notifications.avatar_updated'))
                ->success()
                ->send();

            $this->redirect(route('account.profile'), navigate: true);
            return;
        }


        try {
            $this->avatar->storeAs('public/avatars', $this->user->id . '.png');
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        activity()
            ->logName('account')
            ->description('account:avatar.update')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/change_avatar.notifications.avatar_updated'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'), navigate: true);
    }

    public function resetAvatar()
    {
        Storage::disk('public')->delete('avatars/' . $this->user->id . '.png');

        $this->user->update([
            'custom_avatar_url' => null,
        ]);

        activity()
            ->logName('account')
            ->description('account:avatar.reset')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('components/modals/account/change_avatar.notifications.avatar_reset'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'), navigate: true);
    }

    public function mount()
    {
        if (!setting('profile_enable_change_avatar')) {
            abort(403);
        }

        $this->user = Auth::user();
        $this->customAvatarUrl = $this->user->custom_avatar_url;
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.change-avatar');
    }
}
