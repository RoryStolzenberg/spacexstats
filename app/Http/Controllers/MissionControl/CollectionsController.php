<?php 
 namespace SpaceXStats\Http\Controllers;

class CollectionsController extends Controller {

    // GET /missioncontrol/collections/index
    public function index() {
        return view('missionControl.collections.index');
    }

    // GET /missioncontrol/collections/{collection_id}
    public function get($collection_id) {
        return view('missionControl.collections.grt');
    }

    // GET /missioncontrol/collections/{collection_id}/edit
    public function edit($collection_id) {
        return view('missionControl.collections.edit');
    }

}