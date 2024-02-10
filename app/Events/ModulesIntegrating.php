<?php

namespace App\Events;

use App\Services\ModuleIntegrationCollector;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModulesIntegrating
{
    use Dispatchable, SerializesModels;

    public $collector;

    /**
     * Create a new event instance.
     *
     * @param ModuleIntegrationCollector $collector
     */
    public function __construct(ModuleIntegrationCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
