<?php 
 namespace SpaceXStats\Http\Controllers\Live;

use SpaceXStats\Http\Controllers\Controller;

class LiveController extends Controller {

    // live, GET.
    public function live() {
        return view('live');
    }
}