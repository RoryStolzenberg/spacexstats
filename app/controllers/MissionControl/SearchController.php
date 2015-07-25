<?php
class SearchController extends Controller {
    private $elasticsearch;

    public function __construct(\SpaceXStats\Search\SearchProvider $searchProvider) {
        $this->elasticsearch = $searchProvider;
    }

    // GET
    public function search() {

        // Grab the input

        // Set the client
        //$elasticsearch->


        return View::make('missionControl.search', array(

        ));
    }
}