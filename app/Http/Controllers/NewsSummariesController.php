<?php 
 namespace SpaceXStats\Http\Controllers;

use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Models\Object;

class NewsSummariesController extends Controller {

    // GET: /newsSummaries
    public function index() {
        $newsSummaries = Object::where('subtype', MissionControlSubtype::NewsSummary)->get();

        return view('newsSummaries', array(
            'newsSummaries' => $newsSummaries
        ));
    }

    // GET: /newsSummaries/2015/07
    public function get($year, $month) {

    }
}