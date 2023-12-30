<?php

namespace App\Livewire\Admin\Alerts;

use App\Models\Alert;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AlertEdit extends Component
{
    use WithFileUploads;

    public $alertId;
    public $alert;
    public $icon = 'icon-bell';
    public $title;
    public $type = 'info';
    public $message;
    public $existingFiles = [];
    public $files = [];

    #[On('updateMarkdown')]
    public function updateMarkdown($values): void
    {
        $this->message = $values;
    }

    #[On('updateIcon')]
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function removeFile($fileName)
    {
        if (!Storage::disk('public')->exists('alerts/' . $this->alert->id . '/' . $fileName)) {
            return;
        }

        Storage::disk('public')->delete('alerts/' . $this->alert->id . '/' . $fileName);

        if (count(Storage::disk('public')->files('alerts/' . $this->alert->id)) === 0) {
            Storage::disk('public')->deleteDirectory('alerts/' . $this->alert->id);
            $this->existingFiles = [];
        }else{
            $this->existingFiles = Storage::disk('public')->files('alerts/' . $this->alert->id);
        }

    }

    public function updateAlert()
    {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'icon' => 'required',
            'files' => 'nullable',
        ]);

        $this->alert->title = $this->title;
        $this->alert->type = $this->type;
        $this->alert->icon = $this->icon;
        if ($this->message) {
            $this->alert->message = $this->message;
        }

        try {
            $this->alert->save();
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('sendToConsole', $e->getMessage());
            return;
        }

        if ($this->files) {
            foreach ($this->files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    continue;
                }
                Storage::disk('public')->putFileAs('alerts/' . $this->alert->id, $file, $file->getClientOriginalName());
            }
        }

        activity('system')
            ->performedOn($this->alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $this->alert->title . ' (' . $this->alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->log('alert.updated');

        Notification::make()
            ->title(__('pages/admin/alerts/messages.notifications.alert_updated'))
            ->success()
            ->send();

        return redirect()->route('admin-alert-list');
    }

    public function mount($alertId)
    {
        $this->alert = Alert::find($alertId);
        $this->alertId = $this->alert->id;
        $this->title = $this->alert->title;
        $this->type = $this->alert->type;
        $this->icon = $this->alert->icon;
        $this->message = $this->alert->message;
        $this->existingFiles = Storage::disk('public')->files('alerts/' . $this->alert->id);
    }

    public function render()
    {
        return view('livewire.admin.alerts.alert-edit')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.alerts.edit')
            ]);
    }
}
