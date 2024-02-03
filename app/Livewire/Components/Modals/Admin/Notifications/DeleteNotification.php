<?php

namespace App\Livewire\Components\Modals\Admin\Notifications;

use App\Models\Notification;
use Exception;
use LivewireUI\Modal\ModalComponent;
use Storage;

class DeleteNotification extends ModalComponent
{
    public $notificationId;

    public function deleteNotification()
    {
        try {
            $notification = Notification::findOrFail($this->notificationId);
            $notification->delete();

            Storage::disk('public')->deleteDirectory('notifications/' . $this->notificationId);
        }catch (Exception $e) {
            \Filament\Notifications\Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        \Filament\Notifications\Notification::make()
            ->title(__('components/modals/admin/delete_notification.notifications.notification_deleted'))
            ->success()
            ->send();

        return redirect()->route('admin.notifications');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.notifications.delete-notification');
    }
}
