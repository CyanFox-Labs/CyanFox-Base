<?php

namespace App\View\Components;

use TallStackUi\View\Components\Interaction\Dialog;

class CustomDialog extends Dialog
{
    public function cancelColor(): string
    {
        return 'gray';
    }
}
