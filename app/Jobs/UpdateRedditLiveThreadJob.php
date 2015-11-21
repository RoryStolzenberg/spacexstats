<?php

namespace SpaceXStats\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use Illuminate\Contracts\Bus\SelfHandling;
use SpaceXStats\Facades\BladeRenderer;

class UpdateRedditLiveThreadJob extends Job implements SelfHandling, ShouldQueue
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
        $templatedOutput = View::make('livethreadcontents', [
            'updates' => collect(Redis::lrange('live:updates', 0, -1))->reverse()->map(function($update) {
                return json_decode($update);
            })
        ])->render();

        // Connect to Reddit
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        // Update Thread
        if (Redis::exists('live:reddit:thing')) {
            $reddit->thing(Redis::get('live:reddit:thing'))->edit($templatedOutput);
        }
    }
}
