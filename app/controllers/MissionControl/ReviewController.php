<?php

class ReviewController extends BaseController {
    // GET
    public function index() {
        return View::make('missionControl.review.index', array(
            'title' => 'Review',
            'currentPage' => 'review'
        ));
    }

    // AJAX GET
    public function get() {
        $objectsToReview = Object::queued()->with('user', 'tags')->get();
        return Response::json($objectsToReview);
    }

    // AJAX POST
    public function update($object_id) {
        if (Input::has(['status', 'visibility'])) {

            $object = Object::find($object_id);

            if (Input::get('status') == "Published") {
                $object->fill(Input::only(['status', 'visibility']));
                $object->actioned_at = \Carbon\Carbon::now();


                // Add the object to our elasticsearch node
                Search::indexObject($object);

                // if it is a file, add it and thumbs to S3
                if ($object->hasFile()) {
                    // Open connection
                    $s3 = \Aws\S3\S3Client::factory([
                        'key' => Credential::AWSKey,
                        'secret' => Credential::AWSSecret
                    ]);

                    // Put the necessary objects
                    if (!is_null($object->filename)) {
                        $s3->putObject([
                            'Bucket' => Credential::AWSS3Bucket,
                            'Key' => $object->filename,
                            'Body' => fopen('media/full/' . $object->filename, 'rb'),
                            'ACL' => 'public-read'
                        ]);
                        unlink('media/full' . $object->filename);
                    }

                    if (!is_null($object->thumb_large)) {

                    }

                    if (!is_null($object->thumb_small)) {

                    }
                }

                $object->save();

            } elseif (Input::get('status') == "Deleted") {
                $object->delete();
            }

            return Response::json(true);
        } else {
            return Response::json(false, 400);
        }
    }
}

