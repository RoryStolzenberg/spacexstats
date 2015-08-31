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
        return Response::json($objectsToReview, 200);
    }

    // AJAX POST
    public function update($object_id) {
        if (Input::has(['status', 'visibility'])) {

            $object = Object::find($object_id);

            if (Input::get('status') == "Published") {

                // Put the necessary objects to S3
                $object->putToS3();

                // Update the object properties
                $object->fill(Input::only(['status', 'visibility']));
                $object->actioned_at = \Carbon\Carbon::now();

                // Add the object to our elasticsearch node
                Search::index($object);

                // Save the object if there's no errors
                $object->save();

            } elseif (Input::get('status') == "Deleted") {
                $object->delete();
            }

            return Response::json(null, 204);
        }
        return Response::json(false, 400);
    }
}

