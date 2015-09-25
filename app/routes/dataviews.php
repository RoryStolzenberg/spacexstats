<?php
Route::group(array('prefix' => 'missioncontrol/dataviews'), function() {

    Route::post('/create', array(
        'as' => 'missionControl.dataviews.create',
        'uses' => 'DataViewsController@create'
    ))->before('mustBe:Administrator');

    Route::get('/{dataview_id}', array(
        'as' => 'missionControl.dataviews.get',
        'uses' => 'DataViewsController@get'
    ))->before('mustBe:Subscriber');

    Route::patch('/{dataview_id}/edit', array(
        'as' => 'missionControl.dataviews.edit',
        'uses' => 'DataViewsController@edit'
    ))->before('mustBe:Administrator');

    Route::get('/', array(
        'as' => 'missionControl.dataviews.index',
        'uses' => 'DataViewsController@index'
    ))->before('mustBe:Administrator');
});