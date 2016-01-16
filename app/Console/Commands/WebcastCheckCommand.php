<?php

namespace SpaceXStats\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use SpaceXStats\Events\WebcastStartedEvent;
use SpaceXStats\Events\WebcastEndedEvent;
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
        /*$youtube = new Client();

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
        }(*/

        $isLive = true;
        $videoId = 'xnWKz7Cthkk';
        $viewers = 1;

        // If the livestream is active now, and wasn't before, or vice versa, send an event
        if ($isLive && (Redis::hget('webcast', 'isLive') == 'false' || !Redis::hexists('webcast', 'isLive'))) {

            // Grab all the relevant SpaceX youtube Livestreams, and create an event
            $videos = $this->getMultipleYoutubeLivestreams($videoId); // $searchResponse->items[0]->id->videoId
            event(new WebcastStartedEvent($videos));

        } elseif (!$isLive &&  Redis::hget('webcast', 'isLive') == 'true') {

            // turn off the spacex webcast
            event(new WebcastEndedEvent("spacex", false));
        }

        // Set the Redis properties
        Redis::hmset('webcast', 'isLive', $isLive === true ? 'true' : 'false', 'viewers', $viewers);

        // Add to Database if livestream is active
        if ($isLive) {
            WebcastStatus::create([
                'viewers' => $viewers
            ]);
        }
    }

    private function getMultipleYoutubeLivestreams($preliminaryVideoId) {
        // Extract via regex the specific metadata list that we need
        if (preg_match('/"multifeed_metadata_list":"(\S+?)"/', file_get_contents('https://youtube.com/watch?v=' . $preliminaryVideoId), $output) !== 0) {
            // replace unicode representations of ampersand?
            $multifeedMetaDataList = str_replace('\u0026', '&', $output[1]);

            // urldecode and split on comma
            $multifeedMetaDataList = explode(",", urldecode($multifeedMetaDataList));

            $videos = [];
            foreach ($multifeedMetaDataList as $feed) {

                preg_match('/id=([^&]*)/', $feed, $output);

                if ($output[1] === $preliminaryVideoId) {
                    $videos['spacex'] = $preliminaryVideoId;
                } else {
                    $videos['spacexClean'] = $output[1];
                }
            }

        // No other videos could be found, just return the spacex main stream
        } else {
             $videos['spacex'] = $preliminaryVideoId;
        }

        return $videos;
    }
}
