<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Notification;
use Exception;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class UpdateNotification extends Component implements HasForms
{
    use WithFileUploads, InteractsWithForms;

    public $notification;
    public $notificationId;

    public $title;
    public ?array $messageData = [];
    public $type = 'info';
    public $icon = 'icon-bell';
    public $dismissible = true;
    public $location = 'home';
    public $tmpAttachmentId;
    public $attachments = [];
    public $uploadedAttachments = [];
    public $storedAttachments = [];

    #[On('updateIcon')]
    public function updateIcon($icon)
    {
        $this->icon = $icon;
    }

    protected function getForms(): array
    {
        return [
            'messageContent',
        ];
    }

    public function messageContent(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('messageContent')
                    ->name(__('pages/admin/notifications/messages.message'))
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->required(),
            ])
            ->statePath('messageData');
    }

    public function uploadAttachmentsToTemp()
    {
        $this->validate([
            'attachments' => 'required',
        ]);

        if ($this->tmpAttachmentId == null) {
            $this->tmpAttachmentId = Str::random(10);
        }

        foreach ($this->attachments as $attachment) {
            if (in_array('tmp/' . $this->tmpAttachmentId . '/' . $attachment->getClientOriginalName(), $this->uploadedAttachments)) {
                continue;
            }

            $this->uploadedAttachments[] = $attachment->storeAs('tmp/' . $this->tmpAttachmentId, $attachment->getClientOriginalName(), 'public');
        }

        $this->attachments = [];
    }

    public function removeAttachmentFromTemp($attachmentName)
    {
        Storage::disk('public')->delete('tmp/' . $this->tmpAttachmentId . '/' . $attachmentName);
        $this->uploadedAttachments = array_diff($this->uploadedAttachments, ['tmp/' . $this->tmpAttachmentId . '/' . $attachmentName]);
    }

    public function removeAttachment($attachmentName)
    {
        Storage::disk('public')->delete('notifications/' . $this->notification->id . '/' . $attachmentName);
        $this->storedAttachments = array_diff($this->storedAttachments, ['notifications/' . $this->notification->id . '/' . $attachmentName]);
    }

    public function updateNotification()
    {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'icon' => 'required',
            'dismissible' => 'required',
            'location' => 'required',
        ]);

        $this->notification->update([
            'title' => $this->title,
            'message' => $this->messageData['messageContent'],
            'type' => $this->type,
            'icon' => $this->icon,
            'dismissible' => $this->dismissible,
            'location' => $this->location,
            'attachments' => $this->uploadedAttachments,
        ]);

        $files = Storage::disk('public')->files('tmp/' . $this->tmpAttachmentId);

        foreach ($files as $file) {
            $fileName = basename($file);
            Storage::disk('public')->move($file, 'notifications/' . $this->notification->id . '/' . $fileName);
        }

        Storage::disk('public')->deleteDirectory('tmp/' . $this->tmpAttachmentId);

        \Filament\Notifications\Notification::make()
            ->success()
            ->title(__('pages/admin/notifications/update_notification.notifications.notification_updated'))
            ->send();

        $this->redirect(route('admin.notifications'), navigate: true);
    }


    public function mount()
    {
        try {
            $this->notification = Notification::findOrFail($this->notificationId);
        } catch (Exception) {
            abort(404);
        }

        $this->title = $this->notification->title;
        $this->messageContent->fill(['messageContent' => $this->notification->message]);
        $this->type = $this->notification->type;
        $this->icon = $this->notification->icon;
        $this->dismissible = $this->notification->dismissible;
        $this->location = $this->notification->location;
        $this->storedAttachments = Storage::disk('public')->files('notifications/' . $this->notification->id);
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.notifications.update-notification')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.notifications.update_notification', ['notification' => $this->notification->title])]);
    }
}
