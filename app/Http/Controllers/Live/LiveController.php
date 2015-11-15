<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use SpaceXStats\Events\Live\LiveStartedEvent;
use SpaceXStats\Events\Live\LiveUpdateCreatedEvent;
use SpaceXStats\Events\Live\LiveUpdateUpdatedEvent;
use SpaceXStats\Events\Live\LiveEndedEvent;
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

        $js = [
            'auth' => (Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin(),
            'mission' => Mission::future()->first(),
            'isActive' => Redis::get('live:active') == true,
            'updates' => collect(Redis::lrange('live:updates', 0, -1))->map(function($update) {
                return json_decode($update);
            }),
            'title' => Redis::get('live:title'),
            'reddit' => Redis::hgetall('live:reddit'),
            'sections' => json_decode(Redis::get('live:sections')),
            'resources' => json_decode(Redis::get('live:resources')),
            'description' => Redis::get('live:description')
        ];

        if ((Auth::check() && Auth::user()->isLaunchController()) || Auth::IsAdmin()) {
            $js['cannedResponses'] = Redis::hgetall('live:cannedResponses');
        }

        JavaScript::put($js);

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
            'updateType' => Input::get('messageType')
        ]);

        // Add to Redis
        Redis::rpush('live:updates', json_encode($liveUpdate));

        // Push into Websockets
        event(new LiveUpdateCreatedEvent($liveUpdate));

        // Push to queue for Reddit
        $job = (new UpdateRedditLiveThreadJob())->onQueue('live');
        $this->dispatch($job);

        // Add to DB
        //\SpaceXStats\Models\LiveUpdate::create($liveUpdate->toArray());

        // Respond
        return response()->json(null, 204);
    }

    // /send/message, PATCH.
    public function editMessage() {
        // Find message in Redis
        $id = Input::get('id');
        $liveUpdate = new LiveUpdate(json_decode(Redis::lindex('live:updates', $id)));

        // Update
        $liveUpdate->setUpdate(Input::get('update'));

        // Repush into Redis
        Redis::lset('live:updates', $id, json_encode($liveUpdate));

        // Push into websockets
        event(new LiveUpdateUpdatedEvent($liveUpdate));

        // Push to queue for Reddit
        $job = (new UpdateRedditLiveThreadJob())->onQueue('live');
        $this->dispatch($job);

        // Repush to DB

        return response()->json(null, 204);
    }

    // /live/send/settings, POST.
    public function editSettings() {
        // Fetch settings

        // patch

        // Websockets

        // Push to queue for Reddit

        return response()->json(null, 204);
    }

    public function editCannedResponses() {
        // Reset Canned Responses

        return response()->json(null, 204);
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
        Redis::set('live:description', Input::get('description'));
        Redis::set('live:isForLaunch', Input::get('isForLaunch'));

        Redis::set('live:resources', json_encode(Input::get('resources')));
        Redis::set('live:sections', json_encode(Input::get('sections')));

        // Create the canned responses
        Redis::hmset('live:cannedResponses', [
            'holdAbort' => 'HOLD HOLD HOLD',
            'tMinusTen' => 'T-10 seconds until launch',
            'liftoff' => 'Liftoff of ' . Mission::future()->first()->name . '!',
            'maxQ' => 'MaxQ, at this point in flight maximum aerodynamic pressure on the vehicle is occurring.',
            'meco' => 'MECO! Main Engine Cutoff. The vehicles first stage engines have shutdown in preparation for stage separation.',
            'stageSep' => 'Stage separation confirmed.',
            'mVacIgnition' => "Falcon's upper stage engine has ignited.",
            'seco' => 'SECO! Second Stage Engine Cutoff. Falcon is now in orbit.',
            'missionSuccess' => 'Success! SpaceX has completed another successful mission.',
            'missionFailure' => 'We appear to have had a failure. We will bring more information to you as it is made available.'
        ]);

        // Render the Reddit thread template
        $templatedOutput = BladeRenderer::render('livethreadcontents', array());

        // Create the Reddit thread (create a service for this)
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        // Create a post
        $response = $reddit->subreddit('echocss')->submit([
            'kind' => 'self',
            'sendreplies' => true,
            'text' => $templatedOutput,
            'title' => Input::get('reddit.title')
        ]);

        // error check reddit here

        // Set the Reddit redis parameters
        Redis::hmset('live:streams', array(
            'thing' => $response->data->name,
            'title' => Input::get('redditTitle')
        ));

        // Broadcast event to turn on spacexstats live
        event(new LiveStartedEvent([
            'active' => true,
            'spacexstream' => Input::get('spacexstream'),
            'nasastream' => Input::get('nasastream'),
            'countdownTo' => Input::get('countdownTo'),
            'title' => Input::get('title'),
            'reddit' => [
                'title' => Input::get('reddit.title'),
                'thing' => Input::get('reddit.thing'),
            ],
            'description' => Input::get('description'),
            'isForLaunch' => Input::get('isForLaunch'),
            'resources' => Input::get('resources'),
            'sections' => Input::get('sections'),
        ]));

        // Respond
        return response()->json(null, 204);
    }

    public function destroy() {
        // Disable access
        if (Auth::user()->isLaunchController()) {
            Auth::user()->launch_controller_flag = false;
            Auth::user()->save();
        }

        // Turn off SpaceXStats Live
        Redis::set('live:active', false);

        // Clean up all spacexstats live redis keys
        Redis::del(['live:streams', 'live:title', 'live:description', 'live:resources', 'live:sections', 'live:updates',
            'live:countdownTo', 'live:discussion', 'live:isForLaunch', 'live:cannedResponses', 'live:reddit']);

        // Send out event
        event(new LiveEndedEvent());

        return response()->json(null, 204);
    }
}