<?php 
namespace SpaceXStats\Http\Controllers\MissionControl;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use SpaceXStats\Facades\Search;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Jobs\PutObjectToCloudJob;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\VisibilityStatus;
use SpaceXStats\Services\DeltaVCalculator;
use SpaceXStats\Models\Award;
use SpaceXStats\Models\Object;
use SpaceXStats\Services\SubscriptionService;

class ReviewController extends Controller {

    // GET
    public function index() {
        return view('missionControl.review.index');
    }

    // AJAX GET
    public function get(DeltaVCalculator $deltaV) {
        $objectsToReview = Object::where('status', ObjectPublicationStatus::QueuedStatus)->orderBy('created_at', 'ASC')->with('user', 'tags')->get()->map(function($objectToReview) use ($deltaV) {
            $objectToReview->deltaV = $deltaV->calculate($objectToReview);
            return $objectToReview;
        });

        return response()->json($objectsToReview, 200);
    }

    // AJAX POST
    public function update(SubscriptionService $subscriptionService, DeltaVCalculator $deltaV, $object_id) {
        if (Input::has(['status', 'visibility'])) {

            $object = Object::find($object_id);

            if (Input::get('status') == ObjectPublicationStatus::PublishedStatus) {

                DB::transaction(function() use ($object, $subscriptionService, $deltaV) {
                    // Put the necessary files to S3 (and maybe local)
                    if (Input::get('visibility') == VisibilityStatus::PublicStatus) {
                        $object->putToLocal();
                    }

                    $job = (new PutObjectToCloudJob($object))->onQueue('uploads');
                    $this->dispatch($job);

                    // Update the object properties
                    $object->fill(Input::only(['status', 'visibility']));
                    $object->actioned_at = Carbon::now();

                    // Save the object if there's no errors
                    $object->save();

                    // Add the object to our elasticsearch node
                    Search::index($object->search());

                    // Create an award wih DeltaV
                    $award = Award::create([
                        'user_id'   => $object->user_id,
                        'object_id' => $object->object_id,
                        'type'      => 'Created',
                        'value'     => $deltaV->calculate($object)
                    ]);

                    // Once done, extend subscription
                    $subscriptionService->incrementSubscription($object->user, $award);
                });

            } elseif (Input::get('status') == "Deleted") {
                $object->delete();
            }

            return response()->json(null, 204);
        }
        return response()->json(false, 400);
    }
}

