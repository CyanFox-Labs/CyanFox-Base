<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Notification;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class CreateNotification extends Component implements HasForms
{
    use WithFileUploads, InteractsWithForms;

    public $title;
    public ?array $messageData = [];
    public $type = 'info';
    public $icon = 'icon-bell';
    public $dismissible = true;
    public $location = 'home';
    public $tmpAttachmentId;
    public $attachments = [];
    public $uploadedAttachments = [];

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

    public function createNotification()
    {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'icon' => 'required',
            'dismissible' => 'required',
            'location' => 'required',
        ]);

        $notification = Notification::create([
            'title' => $this->title,
            'message' => $this->messageData['messageContent'],
            'type' => $this->type,
            'icon' => $this->icon,
            'dismissible' => $this->dismissible,
            'location' => $this->location,
            'attachments' => $this->uploadedAttachments,
        ]);

        Storage::disk('public')->move('tmp/' . $this->tmpAttachmentId, 'notifications/' . $notification->id);
        Storage::disk('public')->deleteDirectory('tmp/' . $this->tmpAttachmentId);

        \Filament\Notifications\Notification::make()
            ->success()
            ->title(__('pages/admin/notifications/create_notification.notifications.notification_created'))
            ->send();

        $this->redirect(route('admin.notifications'), navigate: true);
    }

    public function mount()
    {
        $this->messageContent->fill(['messageContent' => '']);

    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.notifications.create-notification')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.notifications.create_notification')]);
    }
}
