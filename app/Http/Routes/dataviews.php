<?php
Route::group(array('prefix' => 'missioncontrol/dataviews', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => 'mustBe:Administrator'), function() {
        Route::post('/create', 'DataViewsController@create');
        Route::get('/testquery', 'DataViewsController@testQuery');
        Route::patch('/{dataViewId}/edit', 'DataViewsController@edit');
        Route::get('/', 'DataViewsController@index');
    });
    
    Route::get('/{dataViewId}', 'DataViewsController@get')->before('mustBe:Subscriber');

});