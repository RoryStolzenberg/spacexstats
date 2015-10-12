<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

use SpaceXStats\Http\Controllers\Controller;

class SearchController extends Controller {
    // POST
    public function search() {
        $results = Search::search(Input::get('search'));
        return response()->json($results);
    }
}