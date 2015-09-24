<?php
class DataViewsController extends BaseController {
    public function get($dataview_id) {
        $dataview = DataView::find($dataview_id);
        return View::make('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function create() {
        if (Request::isMethod('get')) {

            return View::make('missioncontrol.dataviews.create');

        } else if (Request::isMethod('post')) {

        }
    }

    public function edit($dataview_id) {
        $dataview = DataView::find($dataview_id);
        return View::make('missionControl.dataviews.edit', array('dataview' => $dataview));
    }

    public function testsql($query) {

    }
}