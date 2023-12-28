<?php

namespace App\Livewire;

use App\Models\Alert;
use Livewire\Component;

class Home extends Component
{

    public $alerts = [];

    public function mount()
    {
        $this->alerts = Alert::all()->sortByDesc('created_at');

    }

    public function render()
    {
        return view('livewire.home')
            ->layout('components.layouts.app', [
                'title' => __('navigation/messages.home')
            ]);
    }
}
