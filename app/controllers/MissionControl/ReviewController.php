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
        $objectsToReview = Object::queued()->get();
        return Response::json($objectsToReview);
    }

    // AJAX POST
    public function update($object_id) {
        if (Input::has(['statusAction', 'visibilityAction'])) {

            $object = Object::find($object_id);

            $object->status = Input::get('statusAction');
            $object->visibility = Input::get('visibilityAction');

            return Response::json($object->save());
        } else {
            return Response::json(false, 400);
        }
    }
}

