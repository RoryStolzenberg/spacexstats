<?php

namespace SpaceXStats\Events;

use SpaceXStats\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use SpaceXStats\Models\LiveUpdate;

class LiveUpdateCreatedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $liveUpdate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LiveUpdate $liveUpdate)
    {
        $this->liveUpdate = $liveUpdate;
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
