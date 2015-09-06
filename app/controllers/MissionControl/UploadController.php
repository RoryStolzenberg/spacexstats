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

                $objectCreators[$i] = App::make('SpaceXStats\Creators\Objects\ObjectFromFile');
                $objectValidities[$i] = $objectCreators[$i]->isValid($files[$i]) ? true : $objectCreators[$i]->getErrors();

                if ($objectValidities[$i] !== true) {
                    $doesNotContainErrors = false;
                }
            }

            // Check if there are errors, if no, add all to db, if yes, return with errors.
            if ($doesNotContainErrors) {
                // add all objects to db
                for ($i = 0; $i < count($files); $i++) {
                    $objectCreators[$i]->create();
                }
            } else {
                return Response::json($objectValidities, 400);
            }

        // NSF Comment
        } else {
            switch (Request::header('Submission-Type')) {

                case 'article':
                    $objectCreator = App::make('SpaceXStats\Creators\Objects\ObjectFromArticle');
                    break;

                case 'pressRelease':
                    $objectCreator = App::make('SpaceXStats\Creators\Objects\ObjectFromPressRelease');
                    break;

                case 'redditComment':
                    $objectCreator = App::make('SpaceXStats\Creators\Objects\ObjectFromRedditComment');
                    break;

                case 'NSFComment':
                    $objectCreator = App::make('SpaceXStats\Creators\Objects\ObjectFromNSFComment');
                    break;

                case 'text':
                    $objectCreator = App::make('SpaceXStats\Creators\Objects\ObjectFromText');
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
}
 