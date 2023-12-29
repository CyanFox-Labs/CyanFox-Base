<?php

namespace App\Livewire\Components\Modals\Account;

use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class UploadProfileImage extends ModalComponent
{
    use WithFileUploads;

    public $profileImage;

    public function getTemporaryImage()
    {
        try {
            return $this->profileImage?->temporaryUrl();
        }catch (Exception $e) {
            return null;
        }
    }

    public function uploadProfileImage()
    {

        if (env('DISABLE_CHANGE_PROFILE_IMAGE')) {
            return;
        }

        $this->validate([
            'profileImage' => 'required|image|max:5000',
        ]);

        try {
            $this->profileImage->storeAs('public/profile-images', auth()->user()->id . '.png');
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());

            activity('system')
                ->performedOn(auth()->user())
                ->causedBy(auth()->user())
                ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
                ->withProperty('ip', request()->ip())
                ->log('account.profile_image_change_failed');
            return;
        }

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.profile_image_change_success');

        Notification::make()
            ->title(__('pages/account/messages.notifications.profile_image_updated'))
            ->success()
            ->send();

        return redirect()->route('profile');
    }

    function resetImage()
    {
        $this->profileImage = null;

        Storage::delete('public/profile-images/' . auth()->user()->id . '.png');

        activity('system')
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->withProperty('name', auth()->user()->username . ' (' . auth()->user()->email . ')')
            ->withProperty('ip', request()->ip())
            ->log('account.profile_image_reset');

        Notification::make()
            ->title(__('pages/account/messages.notifications.profile_image_reset'))
            ->success()
            ->send();

        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.components.modals.account.upload-profile-image');
    }
}
