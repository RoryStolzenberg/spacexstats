<?php

class CollectionsController extends BaseController {

    // GET /missioncontrol/collections/index
    public function index() {
        return View::make('missionControl.collections.index');
    }

    // GET /missioncontrol/collections/{collection_id}
    public function get($collection_id) {
        return View::make('missionControl.collections.grt');
    }

    // GET /missioncontrol/collections/{collection_id}/edit
    public function edit($collection_id) {
        return View::make('missionControl.collections.edit');
    }

}