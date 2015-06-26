<?php
class LocationsController extends BaseController {

    // GET
    public function home() {
        return View::make('locations', array(

        ));
    }

    // AJAX GET
    public function getLocationData() {
        $locations = Location::with('missions')->with('uses')->get();
        return Response::json($locations);
    }
}