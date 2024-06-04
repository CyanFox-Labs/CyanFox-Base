<?php

namespace App\Services;

use Livewire\Component;
use TallStackUi\Traits\Interactions;

class LWComponent extends Component
{
    use Interactions;

    public function log($message, $level = 'info')
    {
        $this->dispatch('logger', ['type' => $level, 'message' => $message]);
    }

    public function renderView($view, $title, $layout = 'components.layouts.guest')
    {
        return view($view)->layout($layout, ['title' => $title]);
    }
}
