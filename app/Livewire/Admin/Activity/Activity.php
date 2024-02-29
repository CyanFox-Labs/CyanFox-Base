<?php

namespace App\Livewire\Admin\Activity;

use Livewire\Attributes\On;
use Livewire\Component;

class Activity extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.activity.activity')
            ->layout('components.layouts.admin', ['title' => __('admin/activity.tab_title')]);
    }
}
