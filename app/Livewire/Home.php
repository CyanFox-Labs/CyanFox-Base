<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Home extends Component
{
    #[On('refresh')]
    public function render()
    {
        return view('livewire.home')
            ->layout('components.layouts.app', ['title' => __('navigation/titles.home')]);
    }
}
