<?php

namespace App\Livewire\Admin\Alerts;

use App\Models\Alert;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AlertCreate extends Component
{
    use WithFileUploads;

    public $icon = 'icon-bell';
    public $title;
    public $type = 'info';
    public $message;
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

    public function createAlert()
    {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'icon' => 'required',
            'files' => 'nullable',
        ]);

        $alert = new Alert();
        $alert->title = $this->title;
        $alert->type = $this->type;
        $alert->icon = $this->icon;
        if ($this->message) {
            $alert->message = $this->message;
        }

        try {
            $alert->save();
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
                Storage::disk('public')->putFileAs('alerts/' . $alert->id, $file, $file->getClientOriginalName());
            }
        }

        activity('system')
            ->performedOn($alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $alert->title . ' (' . $alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->withProperty('new', $alert->toJson())
            ->log('alert.created');

        Notification::make()
            ->title(__('pages/admin/alerts/messages.notifications.alert_created'))
            ->success()
            ->send();

        return redirect()->route('admin-alert-list');
    }

    public function render()
    {
        return view('livewire.admin.alerts.alert-create')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.alerts.create')
            ]);
    }
}
