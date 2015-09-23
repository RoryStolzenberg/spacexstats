<?php
class DataViewsController extends BaseController {
    public function get($id) {
        $dataview = DataView::find($id);
        return View::make('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function create() {
        if (Request::isMethod('get')) {
            return View::make('missionControl.dataviews.create', array('dataview' => $dataview));
        } else if (Request::isMethod('post')) {

        }
    }

    public function edit($id) {
        return View::make('missionControl.dataviews.edit', array('dataview' => $dataview));
    }

    public function testsql($query) {

    }
}