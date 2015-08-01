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

                // Update the object properties
                $object->fill(Input::only(['status', 'visibility']));
                $object->actioned_at = \Carbon\Carbon::now();

                // Put the necessary objects to S3
                $object->putToS3();

                // Add the object to our elasticsearch node
                Search::indexObject($object);

                // Save the object
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

