<?php

namespace App\Livewire\Admin\Alerts;

use App\Models\Alert;
use Exception;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class AlertEdit extends Component
{

    public $alertId;
    public $alert;
    public $icon = 'icon-bell';
    public $title;
    public $type = 'info';
    public $message;

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
            'icon' => 'required'
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
    }

    public function render()
    {
        return view('livewire.admin.alerts.alert-edit')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.alerts.edit')
            ]);
    }
}
