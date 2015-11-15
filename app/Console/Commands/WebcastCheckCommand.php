<?php

namespace SpaceXStats\Console\Commands;

use Illuminate\Console\Command;
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
    protected $description = 'Checks the SpaceX Livestream to see if it is running and fetch the viewer count.';

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
        $livestream = json_decode(file_get_contents('http://xspacexx.api.channel.livestream.com/2.0/livestatus.json'));

        // If the Livestream is active now, and wasn't before, or vice versa, send an event
        if ($livestream->channel->isLive && Redis::hget('webcast', 'isLive') == 'false') {
            event(new WebcastEvent(true));
        } else if ($livestream->channel->isLive && Redis::hget('webcast', 'isLive') == 'false') {
            event(new WebcastEvent(false));
        }

        // Set the Redis properties
        Redis::hmset('webcast', 'isLive', $livestream->channel->isLive === true ? 'true' : 'false', 'viewers', $livestream->channel->currentViewerCount);

        // Add to Database if livestream is active
        if ($livestream->channel->isLive === true) {
            WebcastStatus::create(array(
                'viewers' => $livestream->channel->currentViewerCount
            ));
        }
    }
}
