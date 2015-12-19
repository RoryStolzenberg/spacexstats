<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Library\Enums\MissionControlType;
use Carbon\Carbon;
use JavaScript;
use SpaceXStats\Models\Comment;
use SpaceXStats\Models\Download;
use SpaceXStats\Models\Favorite;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\User;

class MissionControlController extends Controller {

    /**
     * GET (HTTP). Home.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function home() {
		if (Auth::isSubscriber()) {

            // Fetch data
            $objects['latest'] = Object::authedVisibility()->inMissionControl()->orderBy('created_at', 'desc')->take(10)->get();

            $objects['hot'] = Object::authedVisibility()->inMissionControl()
                ->selectRaw('objects.*, LOG10(greatest(1, count(comments.object_id)) + greatest(1, count(favorites.object_id))) / TIMESTAMPDIFF(HOUR, objects.actioned_at, NOW()) as score')
                ->leftJoin('comments', 'comments.object_id', '=', 'objects.object_id')
                ->leftJoin('favorites', 'favorites.object_id', '=', 'objects.object_id')
                ->groupBy('objects.object_id')
                ->orderBy(DB::raw('score'))
                ->take(10)->get();

            $objects['discussions'] = Object::authedVisibility()->inMissionControl()->where('type', MissionControlType::Text)
                ->join('comments', 'comments.object_id', '=', 'objects.object_id')
                ->orderBy('comments.created_at')
                ->select('objects.*')
                ->take(10)
                ->get();

            $objects['mission'] = Object::authedVisibility()->inMissionControl()->whereHas('Mission', function($q) {
                $q->future()->take(1);
            })->take(10)->get();

            $objects['random'] = Object::authedVisibility()->inMissionControl()->orderByRaw("RAND()")->take(10)->get();

            // Leaderboards
            $leaderboards['week'] = User::join('awards', 'awards.user_id', '=', 'users.user_id')
                ->selectRaw('users.user_id, users.username, sum(awards.value) as totalDeltaV')
                ->where('awards.created_at', '>=', Carbon::now()->subWeek())
                ->groupBy('users.user_id')
                ->take(10)->get();

            $leaderboards['month'] = User::join('awards', 'awards.user_id', '=', 'users.user_id')
                ->selectRaw('users.user_id, users.username, sum(awards.value) as totalDeltaV')
                ->where('awards.created_at', '>=', Carbon::now()->subMonth())
                ->groupBy('users.user_id')
                ->take(10)->get();

            $leaderboards['year'] = User::join('awards', 'awards.user_id', '=', 'users.user_id')
                ->selectRaw('users.user_id, users.username, sum(awards.value) as totalDeltaV')
                ->where('awards.created_at', '>=', Carbon::now()->subYear())
                ->groupBy('users.user_id')
                ->take(10)->get();

            $leaderboards['alltime'] = User::join('awards', 'awards.user_id', '=', 'users.user_id')
                ->selectRaw('users.user_id, users.username, sum(awards.value) as totalDeltaV')
                ->groupBy('users.user_id')
                ->take(10)->get();

            // Comments
            $comments = Comment::with(['object' => function($query) {
                $query->select('object_id', 'title');
            }])
                ->with(['user' => function($query) {
                    $query->select('user_id', 'username');
                }])
                ->orderBy('created_at','DESC')
                ->take(10)->get();

            // Favorites
            $favorites = Favorite::with(['object' => function($query) {
                $query->select('object_id', 'title');
            }])
                ->with(['user' => function($query) {
                    $query->select('user_id', 'username');
                }])
                ->orderBy('created_at','DESC')
                ->take(10)->get();

            // Downloads
            $downloads = Download::with(['object' => function($query) {
                $query->select('object_id', 'title');
            }])
                ->with(['user' => function($query) {
                    $query->select('user_id', 'username');
                }])
                ->orderBy('created_at','DESC')
                ->take(10)->get();

            return view('missionControl.home', [
                'upcomingMission' => Mission::future()->first(),
                'leaderboards' => $leaderboards,
                'objects' => $objects,
                'comments' => $comments,
                'favorites' => $favorites,
                'downloads' => $downloads
            ]);
		} else {
            return redirect()->action('MissionControl\MissionControlController@about');
		}
	}

    public function about() {
        if (Auth::isSubscriber()) {
            return redirect('/missioncontrol');
        }

        return view('missionControl.about', [
            'stripePublicKey' => Config::get('services.stripe.public')
        ]);
    }

    public function aboutNextLaunch() {
        return response()->json([
            'nextLaunch' => Mission::with(['vehicle'])->future()->first()
        ]);
    }

    public function aboutTotalData() {
        return response()->json([
            'size'      => round(Object::inMissionControl()->sum('size') / 1000000000, 1) . ' GB',
            'images'    => Object::where('type', MissionControlType::Image)->count(),
            'videos'    => Object::where('type', MissionControlType::Video)->count(),
            'documents' => Object::where('type', MissionControlType::Document)->count()
        ]);
    }

    public function aboutSearch() {
        return response()->json([
            'result' => 1
        ]);
    }
}