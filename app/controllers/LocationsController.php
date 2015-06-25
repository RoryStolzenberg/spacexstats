<?php
class LocationsController extends BaseController {

    // GET
    public function home() {
        return View::make('locations', array(

        ));
    }

    // AJAX GET
    public function getLocationData() {
        $locations = Location::all()->with('missions')->with('uses');
        return Response::json($locations);
    }
}