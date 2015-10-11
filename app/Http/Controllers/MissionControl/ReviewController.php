<?php 
 namespace SpaceXStats\Http\Controllers;

use SpaceXStats\Library\DeltaV;

class ReviewController extends Controller {

    // GET
    public function index() {
        return View::make('missionControl.review.index');
    }

    // AJAX GET
    public function get() {
        $objectsToReview = Object::whereQueued()->with('user', 'tags')->get();
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

                // Finally, give out some deltaV
                Award::create(array(
                    'user_id'   => $object->user_id,
                    'object_id' => $object->object_id,
                    'type'      => 'Created',
                    'value'     => DeltaV::calculate($object)
                ));

            } elseif (Input::get('status') == "Deleted") {
                $object->delete();
            }

            return Response::json(null, 204);
        }
        return Response::json(false, 400);
    }
}

