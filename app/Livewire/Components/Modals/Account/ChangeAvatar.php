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

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:5000',
        ]);

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

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function resetAvatar()
    {
        Storage::disk('public')->delete('profile-images/' . auth()->user()->id . '.png');

        Notification::make()
            ->title(__('components/modals/account/change_avatar.notifications.avatar_reset'))
            ->success()
            ->send();

        $this->closeModal();
        $this->dispatch('refresh');
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
