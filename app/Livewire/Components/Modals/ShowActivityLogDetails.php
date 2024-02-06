<?php

namespace App\Livewire\Components\Modals;

use App\Models\ActivityLog;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ShowActivityLogDetails extends ModalComponent
{
    public $activityLogId;

    public $name;
    public $old;
    public $new;
    public $config;

    public function mount()
    {
        $activity = ActivityLog::find($this->activityLogId);
        $this->name = $activity->subject;
        $this->old = json_encode(json_decode($activity->original_values), JSON_PRETTY_PRINT);
        $this->new = json_encode(json_decode($activity->new_values), JSON_PRETTY_PRINT);

        if ($this->old == "null")
            $this->old = "";

        if ($this->new == "null")
            $this->new = "";

        $this->config = ['colorScheme' => auth()->user()->getColorScheme()];

    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.show-activity-log-details');
    }
}
