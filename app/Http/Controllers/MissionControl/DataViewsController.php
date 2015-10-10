<?php 
 namespace AppHttpControllers;

use \SpaceXStats\Enums\MissionControlType;

class DataViewsController extends Controller {

    public function __construct(DataView $dataview) {
        $this->dataview = $dataview;
    }

    public function get($dataviewId) {
        $dataview = DataView::find($dataviewId);
        return View::make('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function index() {
        JavaScript::put([
            'bannerImages' => Object::where('type', MissionControlType::Image)->get(),
            'dataViews' => DataView::all()->toArray()
        ]);

        return View::make('missionControl.dataviews.index');
    }

    public function create() {
        if ($this->dataview->isValid(Input::get('dataView'))) {

            $dataview = DataView::create(Input::get('dataView'));
            $dataview->setColors();
            $dataview->save();

            return Response::json($dataview);
        }
        return Response::json(400);
    }

    public function edit($dataViewId) {
        if ($this->dataview->isValid(Input::get('dataView'))) {

            $dataview = DataView::find($dataViewId)->fill(Input::get('dataView'))->get();
            $dataview->setColors();
            $dataview->save();

            return Response::json($dataview);
        }
        return Response::json(400);
    }

    public function testQuery() {
        $response = DB::connection('readOnlyMysql')->select(DB::raw(Input::get('q')));
        return Response::json($response);
    }
}