<?php

namespace SpaceXStats\Events\Live;

use SpaceXStats\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LiveDetailsUpdatedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $details;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $details)
    {
        $this->details = $details;
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
