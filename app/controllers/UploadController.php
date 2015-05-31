<?php

class UploadController extends BaseController {
	protected $object;

    public function __construct(Object $object) {
		$this->object = $object;
	}

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
				$objects = array();
				foreach ($uploads as $upload) {
					$objects[] = $upload->addToMissionControl('new');
				}

				return Response::json(['objects' => $objects]);
			} else {
				return Response::json(['errors' => $errors]);
			}	
		}
	}

	// AJAX POST
	public function submit() {
		$submissions = Input::all();

		// File Submissions
		if (Request::header('Submission-Type') == 'files') {
			$errors = [];
			$i = 0;

			// Foreach uploaded file
			foreach (Input::get('files') as $file) {
				// Grab any errors
				$isValidForSubmission = $this->object->isValidForSubmission($file);
				if ($isValidForSubmission !== true) {
					$errors[$i] = $isValidForSubmission;
				}
				$i++;
			}

			// Check if there are errors, if no, add all to db, if yes, return with errors.
			if (empty($errors)) {
				// add to db
				foreach (Input::get('files') as $file) {
					
				}

				// redirect to mission control
				return Redirect::route('missioncontrol');
			} else {
				return Response::json($errors);
			}

		// Written & Post submissions
		} elseif (Request::header('Submission-Type') == 'write' || Request::header('Submission-Type') == 'post') {
			
			$isValidForSubmission = $this->object->isValidForSubmission($object);
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
        return Response::json($connection->get('statuses/show', array('id' => $id)));
    }
}
 