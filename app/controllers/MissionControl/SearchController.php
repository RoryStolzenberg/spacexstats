<?php
class SearchController extends BaseController {
    // GET
    public function search() {

        // Grab the input

        // Set the client
        //$this->elasticsearch->connect()->indices();

        return View::make('missionControl.search', array(

        ));
    }
}