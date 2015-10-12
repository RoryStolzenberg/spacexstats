<?php 
 namespace SpaceXStats\Http\Controllers\Live;

class LiveController extends Controller {

    // live, GET.
    public function live() {
        return view('live');
    }
}