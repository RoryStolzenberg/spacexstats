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
            $object->fill(Input::only(['status', 'visibility']));
            $object->actioned_at = \Carbon\Carbon::now();

            $object->save();

            return Response::json(true);
        } else {
            return Response::json(false, 400);
        }
    }
}

