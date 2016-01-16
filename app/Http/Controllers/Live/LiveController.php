<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use Parsedown;
use SpaceXStats\Events\Live\LiveCountdownEvent;
use SpaceXStats\Events\Live\LiveDetailsUpdatedEvent;
use SpaceXStats\Events\Live\LiveStartedEvent;
use SpaceXStats\Events\Live\LiveUpdateCreatedEvent;
use SpaceXStats\Events\Live\LiveUpdateUpdatedEvent;
use SpaceXStats\Events\Live\LiveEndedEvent;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Jobs\UpdateRedditLiveThreadJob;
use SpaceXStats\Live\LiveUpdate;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\PrelaunchEvent;
use Illuminate\Support\Facades\Log;

class LiveController extends Controller {

    /**
     * GET, /live. Fetches SpaceXStats Live.
     *
     * @return \Illuminate\View\View
     */
    public function live() {

        $isAuthed = (Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin();

        $js = [
            'auth' => $isAuthed,
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
            'streams' => [
                'spacex' => json_decode(Redis::hget('live:streams', 'spacex')),
                'spacexClean' => json_decode(Redis::hget('live:streams', 'spacexClean')),
                'nasa' => json_decode(Redis::hget('live:streams', 'nasa')),
            ],
            'status' => [
                'text' => Redis::get('live:status')
            ]
        ];

        if ($isAuthed) {
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

        // Potentially update the live status if it is not null
        if (!is_null(Input::get('messageType'))) {
            if (in_array(Input::get('messageType'), ['holdAbort', 'terminalCount', 'inProgress', 'missionSuccess', 'missionFailure'])) {
                Redis::set('live:status', Input::get('messageType'));
            }
        }

        // Push into Websockets
        event(new LiveUpdateCreatedEvent($liveUpdate));

        // Push to queue for Reddit
        $job = (new UpdateRedditLiveThreadJob());
        $this->dispatch($job);

        // Add to DB
        \SpaceXStats\Models\LiveUpdate::create($liveUpdate->toArray());

        // Respond
        return response()->json(null, 204);
    }

    // /send/message, PATCH.
    /**
     * @return mixed
     */
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
        $liveUpdateModel = \SpaceXStats\Models\LiveUpdate::where('created_at', $liveUpdate->getCreatedAt())->first();
        $liveUpdateModel->update = Input::get('update');
        $liveUpdateModel->save();

        return response()->json(null, 204);
    }

    // /live/send/details, PATCH.
    /**
     * @return mixed
     */
    public function editDetails() {
        // patch
        Redis::hmset('live:description', [
            'raw' => Input::get('description.raw'),
            'markdown' => Parsedown::instance()->parse(Input::get('description.raw'))
        ]);
        Redis::set('live:resources', json_encode(Input::get('resources')));
        Redis::set('live:sections', json_encode(Input::get('sections')));

        // Websockets
        event(new LiveDetailsUpdatedEvent(Input::all()));

        // Push to queue for Reddit
        $job = (new UpdateRedditLiveThreadJob());
        $this->dispatch($job);

        return response()->json(null, 204);
    }

    /**
     * @return mixed
     */
    public function editCannedResponses() {
        foreach (Input::get('cannedResponses') as $key => $value) {
            $cannedResponses[$key] = $value;
        }
        // Reset Canned Responses
        Redis::hmset('live:cannedResponses', $cannedResponses);
        return response()->json(null, 204);
    }

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function resumeCountdown() {
        // Parse launch date
        $newLaunchDate = Carbon::parse(Input::get('newLaunchDate'));

        // Update Redis
        Redis::hset('live:countdown', 'isPaused', false);
        Redis::hset('live:countdown', 'to', $newLaunchDate->toDateTimeString());

        // Event
        event(new LiveCountdownEvent(true, $newLaunchDate));

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

        return response()->json(null, 204);
    }

    /**
     * Create a SpaceXStats Live event. Set all the necessary Redis parameters, render a Reddit Thread template,
     * publish it, then broadcast a LiveStartedEvent to notify websocket listeners.
     *
     * @return mixed
     */
    public function create() {
        // Turn on SpaceXStats Live
        Redis::set('live:active', true);

        // Set the streams available
        Redis::hmset('live:streams', [
            'spacex' => json_encode(Input::get('streams.spacex')),
            'spacexClean' => json_encode(Input::get('streams.spacexClean')),
            'nasa' => json_encode(Input::get('streams.nasa'))
        ]);

        // Set the countdown
        Redis::hmset('live:countdown', [
            'to' => Input::get('countdown.to'),
            'isPaused' => false
        ]);

        // Set the details
        Redis::set('live:title', Input::get('title'));
        Redis::hmset('live:description', [
            'raw' => Input::get('description.raw'),
            'markdown' => Parsedown::instance()->parse(Input::get('description.raw'))
        ]);
        Redis::set('live:isForLaunch', Input::get('isForLaunch'));
        Redis::set('live:resources', json_encode(Input::get('resources')));
        Redis::set('live:sections', json_encode(Input::get('sections')));
        Redis::set('live:status', 'Upcoming');

        // Set the Reddit parameters
        Redis::hmset('live:reddit', [
            'title' => Input::get('reddit.title')
        ]);

        // Create the canned responses
        Redis::hmset('live:cannedResponses', [
            'holdAbort'         => 'HOLD HOLD HOLD. The countdown has been aborted.',
            'terminalCount'     => 'Terminal count has now begun. From this point forward, any scrubs will result in a recycle to T-10 minutes.',
            'inProgress'        => 'Liftoff of ' . Mission::future()->first()->name . '!',
            'maxQ'              => 'MaxQ, at this point in flight, the vehicle is flying through maximum aerodynamic pressure.',
            'MECO'              => "MECO! The vehicle's first stage engines have shutdown in preparation for stage separation.",
            'stageSep'          => 'Stage separation confirmed.',
            'mVacIgnition'      => "Falcon's upper stage Merlin Vacuum engine has ignited for the ride to orbit.",
            'SECO'              => 'SECO! Falcon is now in orbit!',
            'missionSuccess'    => 'Success! SpaceX has completed another successful mission!',
            'missionFailure'    => 'We appear to have had a failure. We will bring more information to you as it is made available.'
        ]);

        // Render the Reddit thread template
        $templatedOutput = view('templates.livethreadcontents')->with(array())->render();

        // Create the Reddit thread (create a service for this)
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('/u/ElongatedMuskrat by /u/EchoLogic. Runs various /r/SpaceX-related tasks.');

        // Create a post
        $subreddit = App::environment('production') ? 'spacex' : 'echocss';

        $response = $reddit->subreddit($subreddit)->submit([
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
            'streams'   => [
                'spacex'        => Input::get('streams.spacex'),
                'spacexClean'   => Input::get('streams.spacexClean'),
                'nasa'          => Input::get('streams.nasa')
            ],
            'countdown'     => [
                'to'        => Input::get('countdown.to'),
                'isPaused'  => false,
            ],
            'title' => Input::get('title'),
            'reddit' => [
                'title' => Input::get('reddit.title'),
                'thing' => $response->data->name,
            ],
            'description' => Redis::hgetall('live:description'),
            'isForLaunch' => Input::get('isForLaunch'),
            'resources' => Input::get('resources'),
            'sections' => Input::get('sections'),
            'status' => 'Upcoming',
            'cannedResponses' => Redis::hgetall('live:cannedResponses')
        ]));

        // Respond
        return response()->json(null, 204);
    }

    /**
     * @return mixed
     */
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
            'live:countdown', 'live:discussion', 'live:isForLaunch', 'live:cannedResponses', 'live:reddit', 'live:status']);

        // Send out event
        event(new LiveEndedEvent());

        return response()->json(null, 204);
    }
}