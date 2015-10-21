<?php 
 namespace SpaceXStats\Http\Controllers\MissionControl;

use SpaceXStats\Http\Controllers\Controller;

class CollectionsController extends Controller {

    // GET /missioncontrol/collections
    public function index() {
        return view('missionControl.collections.index');
    }

    // GET /missioncontrol/collections/{collection_id}
    public function get($collection_id) {
        return view('missionControl.collections.get');
    }

    // PATCH /missioncontrol/collections/{collection_id}
    public function edit($collection_id) {
        return response()->json();
    }

    // PUT /missioncontrol/collections/create
    public function create($collection_id) {
        return response()->json();
    }

    // PUT /missioncontrol/collections/{collection_id}
    public function delete($collection_id) {
        return response()->json();
    }

}