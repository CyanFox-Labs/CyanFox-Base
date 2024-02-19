<?php

namespace App\Livewire\Components\Modals\Account;

use Exception;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Storage;

class ChangeAvatar extends ModalComponent
{
    use WithFileUploads;

    public $avatar;
    public $customAvatarUrl;

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'nullable|image|max:5000',
            'customAvatarUrl' => 'nullable|url',
        ]);

        if ($this->customAvatarUrl) {

            $user = auth()->user();
            $user->custom_avatar_url = $this->customAvatarUrl;

            $user->save();

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
            $this->avatar->storeAs('public/profile-images', auth()->user()->id . '.png');
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        Notification::make()
            ->title(__('components/modals/account/change_avatar.notifications.avatar_updated'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'), navigate: true);
    }

    public function resetAvatar()
    {
        Storage::disk('public')->delete('profile-images/' . auth()->user()->id . '.png');

        $user = auth()->user();
        $user->custom_avatar_url = $this->customAvatarUrl;

        $user->save();

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
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.account.change-avatar');
    }
}
