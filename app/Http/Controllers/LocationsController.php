<?php 
 namespace SpaceXStats\Http\Controllers;
class LocationsController extends Controller {

    // GET
    public function home() {
        return view('locations', array(

        ));
    }

    // AJAX GET
    public function getLocationData() {
        $locations = Location::with('missions')->with('uses')->get();
        return Response::json($locations);
    }
}