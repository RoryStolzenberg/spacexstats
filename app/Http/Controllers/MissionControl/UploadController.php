<?php 
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use SpaceXStats\Facades\Upload;
use SpaceXStats\Http\Controllers\Controller;
use Abraham\TwitterOAuth\TwitterOAuth;
use LukeNZ\Reddit\Reddit;
use SpaceXStats\ModelManagers\Objects\ObjectFromText;
use SpaceXStats\Models\Collection;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\Publisher;
use SpaceXStats\Models\Tag;
use JavaScript;

class UploadController extends Controller {

	public function show() {

        JavaScript::put([
            'tags' => Tag::all(),
            'missions' => Mission::with('featuredImage')->get(),
            'publishers' => Publisher::all(),

        ]);

		return view('missionControl.create', [
            'recentUploads' => Object::inMissionControl()->orderBy('created_at', 'desc')->take(10)->get()
        ]);
	}	

	// AJAX POST
	public function upload()
    {
        if (empty(Input::all())) {
            return response()->json(null, 400);
        }

        $files = Input::file('file');
        $upload = Upload::check($files);

        if ($upload->hasErrors()) {
            return response()->json(['errors' => $upload->getErrors()], 400);
        }

        $objects = $upload->create();
        return response()->json(['objects' => $objects]);
    }

	// AJAX POST
	public function submitFiles() {
        $files = Input::get('data');
        $objectValidities = $objectManagers = $queuedObjects = [];
        $doesNotContainErrors = true;

        // Find each object from file
        for ($i = 0; $i < count($files); $i++) {

            $objectManagers[$i] = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromFile');
            $objectValidities[$i] = $objectManagers[$i]->isValid($files[$i]) ? true : $objectManagers[$i]->getErrors();

            if ($objectValidities[$i] !== true) {
                $doesNotContainErrors = false;
            }
        }

        // Check if there are errors, if no, add all to db, if yes, return with errors.
        if ($doesNotContainErrors) {
            // add all objects to db
            for ($i = 0; $i < count($files); $i++) {
                $queuedObjects[$i] = $objectManagers[$i]->create();
            }

            // nothing bad happened, let's also create an optional collection if asked to
            if (Input::get('collection') != null) {
                $collection = Collection::create([
                    'creating_user_id' =>   Auth::id(),
                    'title' =>              Input::get('collection.title'),
                    'summary' =>            Input::get('collection.summary')
                ]);

                // and associate it with the given files
                $collection->objects()->saveMany($queuedObjects);
            }

        } else {
            return response()->json($objectValidities, 400);
        }

        // redirect to mission control
        Session::flash('flashMessage', 'Done!');
        return response()->json(null, 204);
	}

    public function submitPost() {
        switch (Input::get('type')) {
            case 'tweet':
                $objectCreator = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromTweet');
                break;

            case 'article':
                $objectCreator = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromArticle');
                break;

            case 'pressrelease':
                $objectCreator = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromPressRelease');
                break;

            case 'redditcomment':
                $objectCreator = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromRedditComment');
                break;

            case 'NSFcomment':
                $objectCreator = App::make('SpaceXStats\ModelManagers\Objects\ObjectFromNSFComment');
                break;
            default:
                return response()->json(null, 400);
        }

        if ($objectCreator->isValid(Input::get('data')) === true) {
            // Add to db
            $objectCreator->create();

            // redirect to mission control
            Session::flash('flashMessage', 'Done!');
            return response()->json(null, 204);
        } else {
            return response()->json($objectCreator->getErrors(), 400);
        }
    }

    public function submitWriting(ObjectFromText $objectCreator) {
        if ($objectCreator->isValid(Input::get('data')) === true) {
            $objectCreator->create();

            // redirect to mission control
            Session::flash('flashMessage', 'Done!');
            return response()->json(null, 204);
        } else {
            return response()->json($objectCreator->getErrors(), 400);
        }
    }

    // AJAX GET
    public function retrieveTweet() {
        $twitter = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));
        $tweet = $twitter->get('statuses/show', array('id' => Input::get('id')));

        return response()->json($tweet);
    }

    // AJAX GET
    public function retrieveRedditComment() {
        $reddit = new Reddit(Config::get('services.reddit.username'), Config::get('services.reddit.password'), Config::get('services.reddit.id'),Config::get('services.reddit.secret'));
        $reddit->setUserAgent('/u/ElongatedMuskrat by /u/EchoLogic. Runs various /r/SpaceX-related tasks.');

        $comment = $reddit->getComment(Input::get('url'));
        return response()->json($comment);
    }
}
 