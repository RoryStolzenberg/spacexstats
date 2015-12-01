<?php

namespace SpaceXStats\Events\Live;

use SpaceXStats\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LiveCountdownEvent extends Event  implements ShouldBroadcast
{
    use SerializesModels;

    public $isResuming;
    public $newLaunchTime;

    /**
     * Create a new event instance.
     *
     * @param $isResuming
     * @param null $newLaunchTime
     */
    public function __construct($isResuming, $newLaunchTime = null)
    {
        $this->isResuming = $isResuming;
        $this->newLaunchTime = $newLaunchTime;
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
