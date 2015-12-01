<?php

namespace SpaceXStats\Events\Live;

use SpaceXStats\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use SpaceXStats\Live\LiveUpdate;

class LiveUpdateCreatedEvent extends Event implements ShouldBroadcast
{
    public $liveUpdate;

    /**
     * Create a new event instance.
     *
     * @param LiveUpdate $liveUpdate
     */
    public function __construct(LiveUpdate $liveUpdate)
    {
        $this->liveUpdate = $liveUpdate->jsonSerialize();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['live-updates'];
    }
}
