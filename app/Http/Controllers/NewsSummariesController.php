<?php 
 namespace SpaceXStats\Http\Controllers;

use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\Object;

class NewsSummariesController extends Controller {

    // GET: /newssummaries
    public function index() {
        $newsSummaries = Object::where('subtype', MissionControlSubtype::NewsSummary)->get();

        return view('newsSummaries', [
            'newsSummaries' => $newsSummaries
        ]);
    }

    // GET: /newssummaries/2015/07
    public function get($year, $month) {
        $newsSummary = Object::where('subtype', MissionControlSubtype::NewsSummary)
            ->whereRaw('YEAR(originated_at) = :year WHERE MONTH(originated_at) = :month', [
                'year' => $year,
                'month' => $month
            ])->firstOrFail();

        return view('newsSummary', [
            'newsSummary' => $newsSummary,
            'year' => $year,
            'month' => Carbon::createFromFormat($month, 'm')->format('F')
        ]);
    }
}