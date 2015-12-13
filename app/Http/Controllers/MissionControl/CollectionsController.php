<?php 
 namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Models\Collection;
use SpaceXStats\Models\Mission;

class CollectionsController extends Controller {

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    // GET /missioncontrol/collections
    public function index() {

        // Fetch popular, recently created, and recently added to collections here
        return view('missionControl.collections.index');
    }

    // GET /missioncontrol/collections/{collection_id}
    public function get($collection_id) {
        $collection = Collection::with('objects')->findOrFail($collection_id);

        return view('missionControl.collections.get', array(
            'collection' => $collection
        ));
    }

    // GET /missioncontrol/collections/mission/{slug}
    public function mission($slug) {
        return view('missionControl.collections.mission', [
           'collection' => Mission::whereSlug($slug)->with('objects')->first()
        ]);
    }

    // PATCH /missioncontrol/collections/{collection_id}
    public function edit($collection_id) {
        return response()->json();
    }

    // POST /missioncontrol/collections/create
    public function create() {
        if ($this->collection->isValid(Input::all())) {

            $collection = Collection::create(array(
                'creating_user_id' =>   Auth::id(),
                'title' =>              Input::get('title'),
                'summary' =>            Input::get('summary')
            ));

            return response()->json($collection);
        }
        return response()->json(null, 400);
    }

    // DELETE /missioncontrol/collections/{collection_id}
    public function delete($collection_id) {
        Collection::find($collection_id)->delete();
        return response()->json(null, 204);
    }

    // PATCH /missioncontrol/collections/merge/{first_collection_id}/into/{second_collection_id}
    public function merge() {
        return response()->json();
    }

}