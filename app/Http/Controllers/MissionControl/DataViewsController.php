<?php 
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\DB;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\DataView;

class DataViewsController extends Controller {

    public function __construct(DataView $dataview) {
        $this->dataview = $dataview;
    }

    public function get($dataviewId) {
        $dataview = DataView::find($dataviewId);
        return view('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function index() {
        JavaScript::put([
            'bannerImages' => Object::where('type', MissionControlType::Image)->get(),
            'dataViews' => DataView::all()->toArray()
        ]);

        return view('missionControl.dataviews.index');
    }

    public function create() {
        if ($this->dataview->isValid(Input::get('dataView'))) {

            $dataview = DataView::create(Input::get('dataView'));
            $dataview->setColors();
            $dataview->save();

            return response()->json($dataview);
        }
        return response()->json(400);
    }

    public function edit($dataViewId) {
        if ($this->dataview->isValid(Input::get('dataView'))) {

            $dataview = DataView::find($dataViewId)->fill(Input::get('dataView'))->get();
            $dataview->setColors();
            $dataview->save();

            return response()->json($dataview);
        }
        return response()->json(400);
    }

    public function testQuery() {
        $response = DB::connection('readOnlyMysql')->select(DB::raw(Input::get('q')));
        return response()->json($response);
    }
}