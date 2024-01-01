<?php

namespace App\Livewire\Components\Modals\Admin;

use LivewireUI\Modal\ModalComponent;
use Spatie\Activitylog\Models\Activity;

class ShowActivityLogDetails extends ModalComponent
{

    public $activityId;

    public $name;
    public $old;
    public $new;
    public $config;

    public function mount()
    {
        $activity = Activity::find($this->activityId);
        $this->name = $activity->getExtraProperty("name");
        $this->old = json_encode(json_decode($activity->getExtraProperty("old")), JSON_PRETTY_PRINT);
        $this->new = json_encode(json_decode($activity->getExtraProperty("new")), JSON_PRETTY_PRINT);

        if ($this->old == "null")
            $this->old = "";

        if ($this->new == "null")
            $this->new = "";

        $this->config = ['colorScheme' => auth()->user()->getColorScheme()];

    }

    public function render()
    {
        return view('livewire.components.modals.admin.show-activity-log-details');
    }
}
