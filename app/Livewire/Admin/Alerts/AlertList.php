<?php

namespace App\Livewire\Admin\Alerts;

use Livewire\Component;

class AlertList extends Component
{
    public function render()
    {
        return view('livewire.admin.alerts.alert-list')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.alerts.list')
            ]);
    }
}
