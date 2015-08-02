<?php
use SpaceXStats\Services\ObjectCreatorService;

class UploadController extends BaseController {
    protected $objectCreator;

    public function __construct(ObjectCreatorService $objectCreator) {
        $this->objectCreator = $objectCreator;
    }

	public function show() {

        JavaScript::put([
            'tags' => Tag::all()
        ]);

		return View::make('missionControl.create', array(
			'title' => 'Upload',
			'currentPage' => 'upload',
			'missions' => Mission::all(), // Provide all missions for the rich Select dropdown
		));
	}	

	// AJAX POST
	public function upload()
    {
        if (!empty(Input::all())) {

            $files = Input::file('file');
            $upload = Upload::check($files);

            if ($upload->hasErrors()) {
                return Response::json(['errors' => $upload->getErrors()]);
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
            $files = Input::get('files');
            $objectValidities = [];
            $doesNotContainErrors = true;

            // Find each object from file
            for ($i = 0; $i < count($files); $i++) {
                $objectValidities[$i] = $this->objectCreator->isValid($files[$i]) ? true : $this->objectCreator->getErrors();
                if ($objectValidities[$i] !== true) {
                    $doesNotContainErrors = false;
                }
            }

			// Check if there are errors, if no, add all to db, if yes, return with errors.
			if ($doesNotContainErrors) {

				// add all objects to db
				for ($i = 0; $i < count($files); $i++) {
                    $this->objectCreator->createFromFileSubmission($files[$i]);
                }

				// redirect to mission control
                Session::flash('flashMessage', array(
                    'contents' => 'Done! Your submitted content will be reviewed and published within 24 hours',
                    'type' => 'success'
                ));
				return Response::json(true);

			} else {
				return Response::json($objectValidities, 400);
			}

		// Written & Post submissions
		} elseif (Request::header('Submission-Type') == 'write' || Request::header('Submission-Type') == 'post') {

			$isValidForSubmission = $this->objectCreator->isValid($object);
			if ($isValidForSubmission === true) {
				// Add to db

				// redirect
			} else {
				return Response::json($isValidForSubmission);
			}
		}
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
 