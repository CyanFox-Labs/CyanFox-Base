<?php

namespace App\Livewire\Components\Modals\Admin\Alerts;

use App\Models\Alert;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use LivewireUI\Modal\ModalComponent;

class AlertDelete extends ModalComponent
{

    public $alertId;

    public function deleteAlert()
    {
        $alert = Alert::find($this->alertId);

        $alert->delete();

        Storage::disk('public')->deleteDirectory('alerts/' . $alert->id);

        Notification::make()
            ->title(__('pages/admin/alerts/messages.notifications.alert_deleted'))
            ->success()
            ->send();

        activity('system')
            ->performedOn($alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $alert->title . ' (' . $alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->log('alert.deleted');

        return redirect()->route('admin-alert-list');
    }

    public function render()
    {
        return view('livewire.components.modals.admin.alerts.alert-delete');
    }
}
