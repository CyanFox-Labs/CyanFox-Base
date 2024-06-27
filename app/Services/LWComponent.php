<?php

namespace App\Services;

use Exception;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class LWComponent extends Component
{
    use Interactions;

    public function log($message, $level = 'info')
    {
        if ($message instanceof Exception) {
            $message = $message->getMessage();
        }
        $this->dispatch('logger', ['type' => $level, 'message' => $message]);
    }

    public function renderView($view, $title, $layout = 'components.layouts.guest')
    {
        return view($view)->layout($layout, ['title' => $title]);
    }
}
