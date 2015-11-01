<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
use SpaceXStats\Events\SpaceXStatsLiveStartedEvent;
use SpaceXStats\Facades\BladeRenderer;
use SpaceXStats\Http\Controllers\Controller;
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
            'isActive' => Redis::get('spacexstatslive:active') == true,
            'updates' => Redis::get('spacexstatslive:updates'),
            'mission' => Mission::future()->first()
        ]);

        return view('live');
    }

    // /send/message, POST.
    public function createLiveUpdate() {
        Input::get();

        // Calculate created_at and updated_at and displayed timestamp

        // Expand acronyms, open images, display tweets, etc

        // Websockets

        // Push to queue for Reddit
    }

    // /send/message/{messagetimestamp}/edit, PATCH.
    public function editLiveUpdate() {
        // Find message in Redis

        // patch updated_at property

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
        event(new SpaceXStatsLiveStartedEvent());

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