<?php
 namespace AppHttpControllers;

class SearchController extends Controller {
    // POST
    public function search() {
        $results = Search::search(Input::get('search'));
        return Response::json($results);
    }
}