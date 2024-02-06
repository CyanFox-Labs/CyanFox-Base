<?php

namespace App\Livewire\Components;

use App\Models\DismissedNotification;
use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Notifications extends Component
{
    public $notifications;
    public $site;

    public function mount($site)
    {
        $this->site = $site;
        $this->notifications = $this->getNotifications();
    }

    public function getNotifications()
    {
        $notifications = Notification::all()->sortByDesc('created_at')->filter(function ($notification){
            return $notification->location === $this->site;
        });

        foreach ($notifications as $notification) {
            $notification->dismissed = DismissedNotification::where('user_id', auth()->id())
                ->where('notification_id', $notification->id)
                ->exists();

            $types = [
                'info' => ['badge' => 'bg-blue-500 text-base-100', 'border' => 'border-blue-500'],
                'warning' => ['badge' => 'bg-yellow-500 text-base-100', 'border' => 'border-yellow-500'],
                'update' => ['badge' => 'bg-green-500 text-base-100', 'border' => 'border-green-500'],
                'important' => ['badge' => 'bg-red-500 text-base-100', 'border' => 'border-red-500']
            ];

            $type = $types[$notification->type] ?? $types['info'];

            $notification->badge = $type['badge'];
            $notification->border = $type['border'];

            $filePaths = Storage::disk('public')->files('notifications/' . $notification->id);
            $notification->files = collect($filePaths)->map(function ($path) use ($notification) {
                $fileName = basename($path);
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                return (object)[
                    'path' => $fileName,
                    'name' => $fileName,
                    'isImage' => in_array($fileExtension, ['png', 'jpg', 'jpeg']),
                ];
            });
        }

        return $notifications;
    }

    public function downloadFile($notificationId, $fileName): StreamedResponse
    {
        return response()->streamDownload(function () use ($fileName, $notificationId) {
            echo Storage::disk('public')->get('notifications/' . $notificationId . '/' . $fileName);
            $this->mount($this->site);
        }, $fileName);
    }

    public function dismissNotification($notificationId)
    {
        if (DismissedNotification::where('user_id', auth()->user()->id)->where('notification_id', $notificationId)->exists()) {
            return;
        }

        $dismissedNotification = new DismissedNotification();
        $dismissedNotification->user_id = auth()->user()->id;
        $dismissedNotification->notification_id = $notificationId;
        $dismissedNotification->save();

        $this->notifications = [];
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.notifications');
    }
}
