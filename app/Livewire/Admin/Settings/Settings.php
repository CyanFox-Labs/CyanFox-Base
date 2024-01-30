<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Attributes\Url;
use Livewire\Component;

class Settings extends Component
{

    #[Url]
    public $tab = 'system';

    public function mount()
    {
        if (!in_array($this->tab, ['system', 'auth', 'emails', 'profile', 'security'])) {
            $this->tab = 'system';
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.settings')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.settings.settings')]);
    }
}
