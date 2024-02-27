<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Home extends Component
{
    #[On('refresh')]
    public function render()
    {
        if (setting('auth_enable')) {
            return view('livewire.home')
                ->layout('components.layouts.app', ['title' => __('navigation/titles.home')]);

        }

        return view('livewire.home')
            ->layout('components.layouts.guest', ['title' => __('navigation/titles.home')]);
    }
}
