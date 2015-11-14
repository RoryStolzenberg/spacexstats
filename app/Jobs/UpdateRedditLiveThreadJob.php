<?php

namespace SpaceXStats\Jobs;

use Illuminate\Support\Facades\Config;
use LukeNZ\Reddit\Reddit;
use Illuminate\Contracts\Bus\SelfHandling;
use SpaceXStats\Live\LiveUpdate;

class UpdateRedditLiveThreadJob extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Rerender content
        $templatedOutput = BladeRenderer::render('livethreadcontents', array());

        // Connect to Reddit
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        // Update Thread
        $reddit->thing('foo')->edit($templatedOutput);
    }
}
