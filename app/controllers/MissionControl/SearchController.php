<?php

class SearchController extends BaseController {
    // POST
    public function search() {
        $results = Search::search(Input::get('search'));
        return Response::json($results);
    }
}