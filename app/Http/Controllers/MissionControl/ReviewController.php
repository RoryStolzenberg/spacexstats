<?php 
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\Input;
use SpaceXStats\Facades\Search;
use SpaceXStats\Library\DeltaV;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Models\Award;
use SpaceXStats\Models\Object;

class ReviewController extends Controller {

    // GET
    public function index() {
        return view('missionControl.review.index');
    }

    // AJAX GET
    public function get() {
        $objectsToReview = Object::whereQueued()->with('user', 'tags')->get();
        return response()->json($objectsToReview, 200);
    }

    // AJAX POST
    public function update($object_id) {
        if (Input::has(['status', 'visibility'])) {

            $object = Object::find($object_id);

            if (Input::get('status') == ObjectPublicationStatus::PublishedStatus) {

                // Put the necessary objects to S3
                $object->putToCloud();

                // Update the object properties
                $object->fill(Input::only(['status', 'visibility']));
                $object->actioned_at = Carbon::now();

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

            return response()->json(null, 204);
        }
        return response()->json(false, 400);
    }
}

