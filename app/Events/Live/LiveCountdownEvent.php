<?php

namespace SpaceXStats\Events\Live;

use SpaceXStats\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class LiveCountdownEvent extends Event implements ShouldBroadcast
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
        if ($newLaunchTime != null) {
            $this->newLaunchTime = $newLaunchTime->format('Y-m-d H:i:s');
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
