<?php

namespace SpaceXStats\Events;

use SpaceXStats\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WebcastEvent extends Event implements ShouldBroadcast
{
    public $isActive;

    public function __construct(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['live-updates', 'webcast'];
    }
}
