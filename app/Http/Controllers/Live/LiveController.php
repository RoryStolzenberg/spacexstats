<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
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
            'messages' => Redis::get('spacexstatslive:messages'),
            'mission' => Mission::future()->first()
        ]);

        return view('live');
    }

    // /send/message, POST.
    public function message() {

    }

    // /send/message/{messagetimestamp}/edit, PATCH.
    public function editMessage() {

    }

    // /send/settings, POST.
    public function settings() {

    }

    public function create() {
        // Turn on SpaceXStats Live
        Redis::set('live:active', true);

        // Establish redis parameters
        Redis::hmset('live:streams', array(
            'nasastream' => Input::get('nasastream'),
            'spacexstream' => Input::get('spacexstream')
        ));

        Redis::hset('live:title', Input::get('title'));
        Redis::hset('live:description', Input::get('description'));

        Redis::hmset('live:resources', Input::get('resources'));
        Redis::hmset('live:sections', Input::get('sections'));

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

        // Respond
        return response(null, 204);
    }

    public function destroy() {
        // Turn off SpaceXStats Live
        // Clean up all spacexstats live redis keys
        // Commit to database
        return response(null, 204);
    }
}