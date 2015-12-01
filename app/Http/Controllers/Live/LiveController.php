<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use Parsedown;
use SpaceXStats\Events\Live\LiveCountdownEvent;
use SpaceXStats\Events\Live\LiveStartedEvent;
use SpaceXStats\Events\Live\LiveUpdateCreatedEvent;
use SpaceXStats\Events\Live\LiveUpdateUpdatedEvent;
use SpaceXStats\Events\Live\LiveEndedEvent;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Jobs\UpdateRedditLiveThreadJob;
use SpaceXStats\Live\LiveUpdate;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PrelaunchEvent;

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
            'countdown' => Redis::hgetall('live:countdown'),
            'title' => Redis::get('live:title'),
            'reddit' => Redis::hgetall('live:reddit'),
            'sections' => json_decode(Redis::get('live:sections')),
            'resources' => json_decode(Redis::get('live:resources')),
            'description' => Redis::hgetall('live:description'),
            'streams' => Redis::hgetall('live:streams')
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

        Log::info('push2queue');
        // Push to queue for Reddit
        $job = (new UpdateRedditLiveThreadJob());
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

    public function pauseCountdown() {
        // Update Redis
        Redis::hset('live:countdown', 'isPaused', true);

        // If it relates to a mission (and not a miscellaneous webcast)
        if (Redis::get('live:isForLaunch')) {
            $nextMission = Mission::future()->first();

            // Update mission
            $nextMission->launch_paused = true;
            $nextMission->save();
        }

        event(new LiveCountdownEvent(false));
        return response()->json(null, 204);
    }

    public function resumeCountdown() {
        // Parse launch date
        $newLaunchDate = Carbon::parse(Input::get('newLaunchDate'));

        // Update Redis
        Redis::hset('live:countdown', 'isPaused', false);

        // If it relates to a mission (and not a miscellaneous webcast)
        if (Redis::get('live:isForLaunch')) {
            $nextMission = Mission::future()->first();

            // Create a Prelaunch event
            PrelaunchEvent::create([
                'mission_id' => $nextMission->mission_id,
                'event' => 'Launch Change',
                'occurred_at' => Carbon::now(),
                'scheduled_launch_exact' => $newLaunchDate
            ]);

            // Update mission
            $nextMission->launch_paused = false;
            $nextMission->launch_date_time = $newLaunchDate;
            $nextMission->save();
        }

        // Event
        event (new LiveCountdownEvent(true, $newLaunchDate));

        return response()->json(null, 204);
    }

    public function create() {
        // Turn on SpaceXStats Live
        Redis::set('live:active', true);

        // Establish redis parameters
        Redis::hmset('live:streams', [
            'nasa' => Input::get('nasa'),
            'spacex' => Input::get('spacex')
        ]);

        Redis::hmset('live:countdown', [
            'to' => Input::get('countdown.to'),
            'isPaused' => false
        ]);

        Redis::set('live:title', Input::get('title'));
        Redis::hmset('live:description', [
            'raw' => Input::get('description.raw'),
            'markdown' => Parsedown::instance()->parse(Input::get('description.raw'))
        ]);
        Redis::set('live:isForLaunch', Input::get('isForLaunch'));

        Redis::set('live:resources', json_encode(Input::get('resources')));
        Redis::set('live:sections', json_encode(Input::get('sections')));

        // Set the Reddit redis parameters
        Redis::hmset('live:reddit', [
            'title' => Input::get('reddit.title')
        ]);

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
        $templatedOutput = view('templates.livethreadcontents')->with(array())->render();

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

        Redis::hmset('live:reddit', [
            'thing' => $response->data->name,
        ]);

        // Broadcast event to turn on spacexstats live
        event(new LiveStartedEvent([
            'active' => true,
            'streams' => [
                'spacex' => Input::get('streams.spacex'),
                'nasa' => Input::get('streams.nasa'),
            ],
            'countdown' => [
                'to' => Input::get('countdown.to'),
                'isPaused' => false,
            ],
            'countdownTo' => Input::get('countdownTo'),
            'title' => Input::get('title'),
            'reddit' => [
                'title' => Input::get('reddit.title'),
                'thing' => Input::get('reddit.thing'),
            ],
            'description' => Redis::hgetall('live:description'),
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