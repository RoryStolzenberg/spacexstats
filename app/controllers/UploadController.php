<?php
use SpaceXStats\Library\FileChecker;
use SpaceXStats\Services\ObjectCreatorService;

class UploadController extends BaseController {

	public function show() {
		return View::make('missionControl.create', array(
			'title' => 'Upload',
			'currentPage' => 'upload',
			'missions' => Mission::all() // Provide all missions for the rich Select dropdown
		));
	}	

	// AJAX POST
	public function upload() {
		$uploads = [];
		$errors = [];

		// Check if there is actually something in the POST
		if (empty(Input::all())) {
			return Response::json('', 400);
		} else {
			$i = 0;

			$files = Input::file('file');

			// Iterate over each file
			foreach ($files as $file) {
				$errors[$i] = FileChecker::errors($file);
				$uploads[$i] = FileChecker::create($file);
				$i++;
			}

			// if errors array is empty
			if (!array_filter($errors)) {
				$objects = [];

				foreach ($uploads as $upload) {
					$objects[] = $upload->addToMissionControl();
				}

				return Response::json(['objects' => $objects]);
			} else {
				return Response::json(['errors' => $errors]);
			}	
		}
	}

	// AJAX POST
	public function submit() {
    	// File Submissions
		if (Request::header('Submission-Type') == 'files') {
            $files = Input::get('files');
			$errors = [];
            $objectCreators = [];
            $objects = [];

            // Find each object from file
            for ($i = 0; $i < count($files); $i++) {
                $objects[$i] = Object::find($files[$i]['object_id']);

                $objectCreators[$i] = new ObjectCreatorService($objects[$i]);

                // Grab any errors & place them in an errors array for return to the client
                $isValidForSubmission = $objectCreators[$i]->isValid($files[$i]);

                if ($isValidForSubmission !== true) {
                    $errors[$i] = $isValidForSubmission;
                }
            }

			// Check if there are errors, if no, add all to db, if yes, return with errors.
			if (empty($errors)) {

				// add all objects to db
				for ($i = 0; $i < count($files); $i++) {
                    $objectCreators[$i]->make($files[$i]);
                }

				// redirect to mission control
                Session::flash('flashMessage', array(
                    'contents' => 'Done! Your submitted content will be reviewed and published within 24 hours',
                    'type' => 'success'
                ));
				return Response::json(true);

			} else {
				return Response::json($errors);
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
        foreach($tweet->entities->media as $image) {

            $filename = basename($image->media_url);
            file_put_contents('media/twitter/'.$filename, file_get_contents($image->media_url . ':orig'));
        }

        return Response::json($tweet);
    }
}
 