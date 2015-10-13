<?php 
namespace SpaceXStats\Http\Controllers\Live;

use Illuminate\Support\Facades\Auth;
use JavaScript;
use Illuminate\Support\Facades\Redis;
use SpaceXStats\Http\Controllers\Controller;

class LiveController extends Controller {

    /**
     * GET, /live. Fetches SpaceXStats Live.
     *
     * @return \Illuminate\View\View
     */
    public function live() {

        JavaScript::put([
            'auth' => (Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin(),
            'isActive' => Redis::get('spacexstatslive:isActive') == true,
            'messages' => Redis::get('spacexstatslive:messages')
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
        return response(null, 204);
    }

    public function destroy() {
        // Turn off SpaceXStats Live
        // Clean up all spacexstats live redis keys
        // Commit to database
        return response(null, 204);
    }
}