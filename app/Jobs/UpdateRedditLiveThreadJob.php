<?php

namespace SpaceXStats\Jobs;

use Illuminate\Support\Facades\Config;
use LukeNZ\Reddit\Reddit;
use Illuminate\Contracts\Bus\SelfHandling;
use SpaceXStats\Live\LiveUpdate;

class UpdateRedditLiveThreadJob extends Job implements SelfHandling
{
    public $liveUpdate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(LiveUpdate $liveUpdate)
    {
        $this->liveUpdate = $liveUpdate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        //$reddit->
    }
}
