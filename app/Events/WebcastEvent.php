<?php

namespace SpaceXStats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Redis;

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
    public function __construct($stream, $isActive, $videoId = null)
    {
        if ($stream == "spacex") {
            $this->isActive = $isActive;
            if ($videoId != null) {
                $this->videoId = $videoId;
            }

            // Update the Redis parameters
            $spacexLivestream = json_decode(Redis::hget('live:streams', 'spacex'));
            $spacexLivestream->isActive = $isActive;
            $spacexLivestream->youtubeVideoId = $videoId;
            Redis::hset('live:streams', 'spacex', json_encode($spacexLivestream));
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
