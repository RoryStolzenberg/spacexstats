<?php

use \SpaceXStats\Enums\MissionControlType;

class DataViewsController extends BaseController {
    public function get($dataviewId) {
        $dataview = DataView::find($dataviewId);
        return View::make('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function index() {
        JavaScript::put([
            'bannerImages' => Object::where('type', MissionControlType::Image)->get(),
            'dataViews' => DataView::all()
        ]);

        return View::make('missionControl.dataviews.index');
    }

    public function create() {
        if ($this->dataview->isValid()) {
            return Response::json();
        }
        return Response::json();
    }

    public function edit($dataViewId) {
        if ($this->dataview->isValid()) {
            return Response::json();
        }
        return Response::json();
    }

    public function testQuery($query) {
        $response = DB::connection('readOnlyMysql')->raw($query)->getValue();
        return Response::json($response);
    }
}