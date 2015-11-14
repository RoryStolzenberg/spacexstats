<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use SpaceXStats\Events\LiveStartedEvent;
use SpaceXStats\Events\LiveUpdateCreatedEvent;
use SpaceXStats\Facades\BladeRenderer;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Jobs\UpdateRedditLiveThreadJob;
use SpaceXStats\Live\LiveUpdate;
use SpaceXStats\Models\Mission;

class LiveController extends Controller {

    /**
     * GET, /live. Fetches SpaceXStats Live.
     *
     * @return \Illuminate\View\View
     */
    public function live() {

        JavaScript::put([
            'auth' => (Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin(),
            'mission' => Mission::future()->first(),
            'isActive' => Redis::get('live:active') == true,
            'updates' => collect(Redis::lrange('live:updates', 0, -1))->map(function($update) {
                return json_decode($update);
            })
        ]);

        return view('live');
    }

    /**
     * Creates a live update from a message and actions it.
     *
     * Takes a live update from the POST data,
     * @return \Illuminate\Http\JsonResponse
     */
    public function message() {

        // Create live update
        $liveUpdate = new LiveUpdate([
            'update' => Input::get('message'),
            'updateType' => Input::get('messageType'),
            'id' => \SpaceXStats\Models\LiveUpdate::count() + 1
        ]);

        // Push into Websockets
        event(new LiveUpdateCreatedEvent($liveUpdate));

        // Push to queue for Reddit
        $this->dispatch(new UpdateRedditLiveThreadJob())->onQueue('live');

        // Add to Redis
        Redis::rpush('live:updates', json_encode($liveUpdate));

        // Add to DB
        //\SpaceXStats\Models\LiveUpdate::create($liveUpdate->toArray());

        // Respond
        return response()->json(null, 204);
    }

    // /send/message, PATCH.
    public function editMessage() {
        // Find message in Redis

        // Push into websockets

        // Push to queue for Reddit

        // Repush into Redis

        // Repush to DB

        return response()->json(null, 204);
    }

    // /send/settings, POST.
    public function editSettings() {
        // Fetch settings

        // patch

        // Websockets

        // Push to queue for Reddit
    }

    public function create() {
        // Turn on SpaceXStats Live
        Redis::set('live:active', true);

        // Establish redis parameters
        Redis::hmset('live:streams', array(
            'nasastream' => Input::get('nasastream'),
            'spacexstream' => Input::get('spacexstream')
        ));

        Redis::set('live:countdownTo', Input::get('countdownTo'));

        Redis::set('live:title', Input::get('title'));
        Redis::set('live:reddit:title', Input::get('redditTitle'));
        Redis::set('live:description', Input::get('description'));
        Redis::set('live:isForMission', Input::get('isForMission'));

        Redis::set('live:resources', json_encode(Input::get('resources')));
        Redis::set('live:sections', json_encode(Input::get('sections')));

        // Render the Reddit thread template
        $templatedOutput = BladeRenderer::render('livethreadcontents', array());

        // Create the Reddit thread (create a service for this)
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        // Create a post
        $response = $reddit->subreddit('echocss')->submit(array(
            'kind' => 'self',
            'sendreplies' => true,
            'text' => $templatedOutput,
            'title' => Input::get('redditTitle')
        ));

        // Set the link thread link
        Redis::set('live:reddit:link', 'foo');

        // Broadcast event to turn on spacexstats live
        event(new LiveStartedEvent([
            'active' => true,
            'spacexstream' => Input::get('spacexstream'),
            'nasastream' => Input::get('nasastream'),
            'countdownTo' => Input::get('countdownTo'),
            'title' => Input::get('title'),
            'redditTitle' => Input::get('redditTitle'),
            'redditDiscussion' => Input::get('redditDiscussion'),
            'description' => Input::get('description'),
            'isForMission' => Input::get('isForMission'),
            'resources' => Input::get('resources'),
            'sections' => Input::get('sections'),
        ]));

        // Respond
        return response()->json(null, 204);
    }

    public function destroy() {
        // Turn off SpaceXStats Live
        Redis::set('live:active', false);
        // Clean up all spacexstats live redis keys
        Redis::del(['live.streams', 'live:title', 'live:description', 'live:resources', 'live:sections', 'live:updates', 'live:countdownTo', 'live:discussion']);

        return response()->json(null, 204);
    }
}