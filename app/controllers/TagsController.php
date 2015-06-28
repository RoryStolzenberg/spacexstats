<?php
class TagsController extends BaseController {
    // AJAX GET
    // /tags/all
    public function all() {
        return Response::json(Tags::all());
    }
}
