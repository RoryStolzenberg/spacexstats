<?php 
 namespace SpaceXStats\Http\Controllers;

class LiveController extends Controller {

    // live, GET.
    public function live() {
        return view('live');
    }
}