<?php
class DataViewsController extends BaseController {
    public function get($dataviewId) {
        $dataview = DataView::find($dataviewId);
        return View::make('missionControl.dataviews.get', array('dataview' => $dataview));
    }

    public function create() {
        if (Request::isMethod('get')) {

            return View::make('missionControl.dataviews.create');

        } else if (Request::isMethod('post')) {

        }
    }

    public function edit($dataviewId) {
        $dataview = DataView::find($dataviewId);
        return View::make('missionControl.dataviews.edit', array('dataview' => $dataview));
    }

    public function testsql($query) {

    }
}