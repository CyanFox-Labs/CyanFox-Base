<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ViewIntegration extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $view = viewIntegration()->render($name, function ($content) {
                    return $content;
                });
            @endphp

            {!! $view !!}
        HTML;
    }
}
