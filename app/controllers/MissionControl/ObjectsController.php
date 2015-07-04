<?php
use SpaceXStats\Library\DeltaVCalculator;

class ObjectsController extends BaseController {
    protected $dVCalculator;

    public function __construct(DeltaVCalculator $dVCalculator) {
        $this->dVCalculator = $dVCalculator;
    }

    public function get($object_id) {
        $object = Object::find($object_id);
        
        if ($object->visibility == 'Public' && $object->status == 'Published') {
            return View::make('missionControl.objects.get', array(
                'object' => $object
            ));

        } elseif ($object->visibility == 'Default' && $object->status == 'Published') {
            if (Auth::isSubscriber()) {
                return View::make('missionControl.objects.get', array(
                    'object' => $object
                ));
            }
            return App::abort(401);

        } elseif ($object->visibility == 'Hidden') {
            if (Auth::isAdmin()) {
                return View::make('missionControl.objects.get', array(
                    'object' => $object
                ));
            }
            return App::abort(401);

        }

        return App::abort(401);
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