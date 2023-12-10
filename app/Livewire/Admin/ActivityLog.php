<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ActivityLog extends Component
{
    public function render()
    {
        return view('livewire.admin.activity-log')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.activity_log')
            ]);
    }
}
