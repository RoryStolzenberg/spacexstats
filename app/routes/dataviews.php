<?php
Route::group(array('prefix' => 'missioncontrol/dataviews'), function() {

    Route::post('/create', array(
        'as' => 'missionControl.dataviews.create',
        'uses' => 'DataViewsController@create'
    ))->before('mustBe:Administrator');

    Route::get('/testsql', array(
        'as' => 'missionControl.dataviews.testquery',
        'uses' => 'DataViewsController@testQuery'
    ))->before('mustBe:Administrator');

    Route::get('/{dataViewId}', array(
        'as' => 'missionControl.dataviews.get',
        'uses' => 'DataViewsController@get'
    ))->before('mustBe:Subscriber');

    Route::patch('/{dataViewId}/edit', array(
        'as' => 'missionControl.dataviews.edit',
        'uses' => 'DataViewsController@edit'
    ))->before('mustBe:Administrator');

    Route::get('/', array(
        'as' => 'missionControl.dataviews.index',
        'uses' => 'DataViewsController@index'
    ))->before('mustBe:Administrator');
});