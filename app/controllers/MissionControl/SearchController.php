<?php
class SearchController extends BaseController {
    private $elasticsearch;

    public function __construct(SpaceXStats\Search\SearchProvider $searchProvider) {
        $this->elasticsearch = $searchProvider;
    }

    // GET
    public function search() {

        // Grab the input

        // Set the client
        //$this->elasticsearch->connect()->indices();


        return View::make('missionControl.search', array(

        ));
    }
}