<?php 
 namespace SpaceXStats\Http\Controllers;
use SpaceXStats\Models\Location;

class LocationsController extends Controller {

    // GET
    public function home() {
        return view('locations', []);
    }

    // AJAX GET
    public function getLocationData() {
        $locations = Location::with([])->get();
        return response()->json($locations);
    }
}