<?php
use SpaceXStats\Library\FileChecker;
use SpaceXStats\Services\ObjectActionService;

class UploadController extends BaseController {
    protected $objectActioner;

    public function __construct(ObjectActionService $objectActioner) {
        $this->objectActioner = $objectActioner;
    }

	public function show() {
		return View::make('missionControl.create', array(
			'title' => 'Upload',
			'currentPage' => 'upload',
			'missions' => Mission::all(), // Provide all missions for the rich Select dropdown
            'tags' => Tag::all() // Provide all tags for the tagger component
		));
	}	

	// AJAX POST
	public function upload()
    {
        // New way of uploading
        if (!empty(Input::all())) {

            $files = Input::file('file');

            $upload = Upload::check($files);

            if ($upload->hasErrors()) {
                return Response::json($upload->getErrors());
            }

            $objects = $upload->make();
            return Response::json($objects);

        }
        return Response::json(false, 400);
    }

		// Check if there is actually something in the POST
		/*if (empty(Input::all())) {
			return Response::json(null, 400);
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
		}*/

	// AJAX POST
	public function submit() {
    	// File Submissions
		if (Request::header('Submission-Type') == 'files') {
            $files = Input::get('files');
            $objectValidities = [];
            $doesNotContainErrors = true;

            // Find each object from file
            for ($i = 0; $i < count($files); $i++) {
                //$objects[$i] = Object::find($files[$i]['object_id']);

                $objectValidities[$i] = $this->objectActioner->isValid($files[$i]) ? true : $this->objectActioner->getErrors();
                if ($objectValidities[$i] !== true) {
                    $doesNotContainErrors = false;
                }
            }

			// Check if there are errors, if no, add all to db, if yes, return with errors.
			if ($doesNotContainErrors) {

				// add all objects to db
				for ($i = 0; $i < count($files); $i++) {
                    $this->objectActioner->create($files[$i]);
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
 