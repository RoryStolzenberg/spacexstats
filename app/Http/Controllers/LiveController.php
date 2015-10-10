<?php 
 namespace AppHttpControllers;

class LiveController extends Controller {

    // live, GET.
    public function live() {
        return View::make('live');
    }
}