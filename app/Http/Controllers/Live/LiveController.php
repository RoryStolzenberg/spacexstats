<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use LukeNZ\Reddit\Reddit;
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
        Redis::set('spacexstatslive:active', true);
        // Establish the parameters

        // Create the Reddit thread (create a service for this)
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'), Config::get('services.reddit.secret'));
        $reddit->setUserAgent('ElongatedMuskrat bot by u/EchoLogic. Creates and updates live threads in r/SpaceX');

        $response = $reddit->subreddit('echocss')->submit(array(
            'kind' => 'self',
            'sendreplies' => true,
            'text' => Input::get('description'),
            'title' => Input::get('threadName')
        ));

        return response(json_encode($response), 204);
    }

    public function destroy() {
        // Turn off SpaceXStats Live
        // Clean up all spacexstats live redis keys
        // Commit to database
        return response(null, 204);
    }
}