<?php
use SpaceXStats\Library\DeltaVCalculator;

class ObjectsController extends BaseController {
    protected $dVCalculator;

    public function __construct(DeltaVCalculator $dVCalculator) {
        $this->dVCalculator = $dVCalculator;
    }

    // AJAX GET
    // missioncontrol/object/{object_id}
    public function get($object_id) {
        $object = Object::with('userNote')->find($object_id);

        $viewToMake = View::make('missionControl.objects.get', array(
            'object' => $object
        ));
        
        if ($object->visibility == 'Public' && $object->status == 'Published') {
            return $viewToMake;

        } elseif ($object->visibility == 'Default' && $object->status == 'Published') {
            if (Auth::isSubscriber()) {
                return $viewToMake;
            }
            return App::abort(401);

        } elseif ($object->visibility == 'Hidden') {
            if (Auth::isAdmin()) {
                return $viewToMake;
            }
            return App::abort(401);

        }

        return App::abort(401);
    }

    // AJAX POST
    // missioncontrol/object/{object_id}/favorite
    public function favorite() {

    }

    // AJAX POST
    // missioncontrol/object/{object_id}/download
    public function download() {

    }

    // AJAX POST
    public function calculateDeltaV() {
        if (Auth::isSubscriber()) {
            return Response::json(null);
        } else {
            return Response::json(null, 401);
        }
    }
}