<?php

namespace SpaceXStats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WebcastEvent extends Event  implements ShouldBroadcast
{
    use SerializesModels;

    public $isActive;
    public $videoId;

    /**
     * Create a new event instance.
     *
     * @param $isActive
     * @param null $videoId
     */
    public function __construct($isActive, $videoId = null)
    {
        $this->isActive = $isActive;
        if ($videoId != null) {
            $this->videoId = $videoId;
        }

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
