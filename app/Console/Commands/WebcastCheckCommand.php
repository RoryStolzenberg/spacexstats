<?php

namespace SpaceXStats\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use SpaceXStats\Events\WebcastEvent;
use SpaceXStats\Models\WebcastStatus;

class WebcastCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webcast:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the SpaceX Youtube Channel to see if it is running and fetch the viewer count.';

    protected $channelName = 'spacexchannel';
    protected $channelID = 'UCtI0Hodo5o5dUb67FeUjDeA'; // https://developers.google.com/youtube/v3/docs/channels/list#try-it
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $youtube = new Client();

        $searchResponse = json_decode($youtube->get('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' .
            $this->channelID .
            '&eventType=live&type=video&key=' .
            Config::get('services.youtube.key'))->getBody());

        $isLive = $searchResponse->pageInfo->totalResults != 0;

        // Determine the total number of viewers
        if ($isLive) {
            $videoResponse = json_decode($youtube->get('https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=' .
                $searchResponse->items[0]->id->videoId .
                '&key=' .
                Config::get('services.youtube.key'))->getBody());

            $viewers = $videoResponse->items[0]->liveStreamingDetails->concurrentViewers;

        } else {
            $viewers = 0;
        }

        // If the livestream is active now, and wasn't before, or vice versa, send an event
        if ($isLive && Redis::hget('webcast', 'isLive') == 'false') {
            event(new WebcastEvent(true, $searchResponse->items[0]->id->videoId));

        } elseif (!$isLive &&  Redis::hget('webcast', 'isLive') == 'true') {
            event(new WebcastEvent(false));
        }

        // Set the Redis properties
        Redis::hmset('webcast', 'isLive', $isLive === true ? 'true' : 'false', 'viewers', $viewers);

        // Add to Database if livestream is active
        if ($isLive) {
            WebcastStatus::create(array(
                'viewers' => $viewers
            ));
        }
    }
}
