<?php
class UploadController extends BaseController {

	public function show() {

        JavaScript::put([
            'tags' => Tag::all(),
            'missions' => Mission::with('featuredImage')->get()
        ]);

		return View::make('missionControl.create');
	}	

	// AJAX POST
	public function upload()
    {
        if (!empty(Input::all())) {

            $files = Input::file('file');
            $upload = Upload::check($files);

            if ($upload->hasErrors()) {
                return Response::json(['errors' => $upload->getErrors()], 400);
            }

            $objects = $upload->create();
            return Response::json(['objects' => $objects]);
        }
        return Response::json(false, 400);
    }

	// AJAX POST
	public function submit() {
    	// File Submissions
		if (Request::header('Submission-Type') == 'files') {
            $files = Input::get('data');
            $objectValidities = [];
            $doesNotContainErrors = true;

            // Find each object from file
            for ($i = 0; $i < count($files); $i++) {

                $objectManagers[$i] = App::make('SpaceXStats\Managers\Objects\ObjectFromFile');
                $objectValidities[$i] = $objectManagers[$i]->isValid($files[$i]) ? true : $objectManagers[$i]->getErrors();

                if ($objectValidities[$i] !== true) {
                    $doesNotContainErrors = false;
                }
            }

            // Check if there are errors, if no, add all to db, if yes, return with errors.
            if ($doesNotContainErrors) {
                // add all objects to db
                for ($i = 0; $i < count($files); $i++) {
                    $objectManagers[$i]->create();
                }
            } else {
                return Response::json($objectValidities, 400);
            }
        } else {
            switch (Request::header('Submission-Type')) {

                case 'article':
                    $objectCreator = App::make('SpaceXStats\Managers\Objects\ObjectFromArticle');
                    break;

                case 'pressrelease':
                    $objectCreator = App::make('SpaceXStats\Managers\Objects\ObjectFromPressRelease');
                    break;

                case 'redditcomment':
                    $objectCreator = App::make('SpaceXStats\Managers\Objects\ObjectFromRedditComment');
                    break;

                case 'NSFcomment':
                    $objectCreator = App::make('SpaceXStats\Managers\Objects\ObjectFromNSFComment');
                    break;

                case 'text':
                    $objectCreator = App::make('SpaceXStats\Managers\Objects\ObjectFromText');
                    break;
            }

            if ($objectCreator->isValid(Input::get('data'))) {
                // Add to db
                $objectCreator->create();

            } else {
                return Response::json($objectCreator->getErrors(), 400);
            }
        }

        // redirect to mission control
        Session::flash('flashMessage', array(
            'contents' => 'Done! Your submitted content will be reviewed and published within 24 hours',
            'type' => 'success'
        ));
        return Response::json(true);
	}

    // AJAX GET
    public function retrieveTweet($id) {
        $connection = new Abraham\TwitterOAuth\TwitterOAuth(Credential::TwitterConsumerKey, Credential::TwitterConsumerSecret, Credential::TwitterAccessToken, Credential::TwitterAccessSecret);
        $tweet = $connection->get('statuses/show', array('id' => $id));

        // Store in session for addition to db later
        Session::put('tweet', $tweet);
        if (isset($tweet->entities->media)) {
            foreach($tweet->entities->media as $image) {
                $filename = basename($image->media_url);
                file_put_contents('media/twitter/'.$filename, file_get_contents($image->media_url . ':orig'));
            }
        }

        return Response::json($tweet);
    }

    // AJAX GET
    public function retrieveRedditComment() {
        $reddit = new LukeNZ\Reddit\Reddit(Credential::RedditUsername, Credential::RedditPassword, Credential::RedditID, Credential::RedditSecret);

        $test = $reddit->getComment('https://www.reddit.com/r/redditdev/comments/3ligwq/how_does_a_reddit_bot_differ_from_an_application/cv6sskz');
    }

}
 