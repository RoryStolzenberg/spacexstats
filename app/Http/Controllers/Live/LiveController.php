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
            'isActive' => Redis::get('live:active') == true,
            'updates' => Redis::lrange('live:updates', 0, -1),
            'mission' => Mission::future()->first()
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
        //$this->dispatch(new UpdateRedditLiveThreadJob($liveUpdate))->onQueue('live');

        // Add to Redis
        //Redis::rpush('live:updates', json_encode($liveUpdate));

        // Add to DB
        //\SpaceXStats\Models\LiveUpdate::create($liveUpdate->toArray());

        // Respond
        return response()->json(null, 204);
    }

    // /send/message/{messageid}/edit, PATCH.
    public function editLiveUpdate() {
        // Find message in Redis

        // Websockets

        // Push to queue for Reddit
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

        Redis::set('live:title', Input::get('title'));
        Redis::set('live:description', Input::get('description'));

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
            'title' => Input::get('title')
        ));

        // Broadcast event to turn on spacexstats live
        event(new LiveStartedEvent());

        // Respond
        return response(null, 204);
    }

    public function destroy() {
        // Turn off SpaceXStats Live
        Redis::set('live:active', false);
        // Clean up all spacexstats live redis keys
        Redis::del(['live.streams', 'live:title', 'live:description', 'live:resources', 'live:sections']);
        // Commit to database


        return response(null, 204);
    }
}