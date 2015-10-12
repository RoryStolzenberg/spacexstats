<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

class SearchController extends Controller {
    // POST
    public function search() {
        $results = Search::search(Input::get('search'));
        return response()->json($results);
    }
}