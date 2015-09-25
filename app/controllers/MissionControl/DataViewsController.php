<?php

use \SpaceXStats\Enums\MissionControlType;

class DataViewsController extends BaseController {
    public function get($dataview_id) {
        $dataview = DataView::find($dataview_id);
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

    public function testsql($query) {

    }
}