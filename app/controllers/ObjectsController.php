<?php
use SpaceXStats\Library\DeltaVCalculator;

class ObjectsController extends BaseController {



    // AJAX POST
    public function calculateDeltaV() {
        if (Auth::isSubscriber()) {
            return Redirect::route('missionControl.about');
        } else {
            return Response::json(null, 404);
        }
    }
}