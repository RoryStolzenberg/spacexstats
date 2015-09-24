<?php
Route::group(array('prefix' => 'missioncontrol/dataviews'), function() {

    Route::any('/create', array(
        'as' => 'missionControl.dataviews.create',
        'uses' => 'DataViewsController@create'
    ));

    Route::get('/{dataview_id}', array(
        'as' => 'missionControl.dataviews.get',
        'uses' => 'DataViewsController@get'
    ))->before('mustBe:Subscriber');



    Route::any('/{dataview_id}/edit', array(
        'as' => 'missionControl.dataviews.edit',
        'uses' => 'DataViewsController@edit'
    ))->before('mustBe:Administrator');

});