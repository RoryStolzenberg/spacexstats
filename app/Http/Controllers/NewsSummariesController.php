<?php 
 namespace SpaceXStats\Http\Controllers;

use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class NewsSummariesController extends Controller {

    // GET: /NewsSummaries
    public function index() {
        $newsSummaries = Object::where('subtype', MissionControlSubtype::NewsSummary)->get();

        return view('NewsSummaries', array(
            'NewsSummaries' => $newsSummaries
        ));
    }

    // GET: /NewsSummaries/2015/07
    public function get($year, $month) {

    }
}