<?php

namespace SpaceXStats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class WebcastStartedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $videos;

    /**
     * Create a new event instance.
     *
     * @param $isActive
     * @param null $videoId
     */
    public function __construct($videos)
    {
        foreach ($videos as $videoName => $videoId) {
            // Update the Redis parameters
            $spacexLivestream = json_decode(Redis::hget('live:streams', $videoName));

            if ($spacexLivestream === null) {
                $spacexLivestream = new \stdClass();
            }

            $spacexLivestream->isActive = true;
            $spacexLivestream->isAvailable = true;
            $spacexLivestream->youtubeVideoId = $videoId;

            Redis::hset('live:streams', $videoName, json_encode($spacexLivestream));
        }
        $this->videos = $videos;
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
