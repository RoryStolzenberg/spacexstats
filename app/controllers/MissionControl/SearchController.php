<?php
use SpaceXStats\Enums\MissionControlSubtype;
use SpaceXStats\Enums\MissionControlType;

class SearchController extends BaseController {
    // POST
    public function search() {
        // Grab the input
        $query = Input::get('q');

        // Set the client
        //$this->elasticsearch->connect()->indices();

        // Javascript
        JavaScript::put([
            'missions' => Mission::all(),
            'tags' => Tag::all(),
            'types' => array_merge(MissionControlType::toArray(), MissionControlSubtype::toArray())
        ]);

        return View::make('missionControl.search', array(

        ));
    }
}