<?php
Route::group(array('prefix' => 'missioncontrol/collections', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => 'mustBe:Subscriber'), function() {
        Route::get('/', 'CollectionsController@index');

        Route::get('/mission/{slug}', 'CollectionsController@mission');
        Route::get('/{collection_id}', 'CollectionsController@get');

        Route::post('/create', 'CollectionsController@create');
        Route::patch('/{collection_id}', 'CollectionsController@edit');

        Route::delete('/{collection_id}', 'CollectionsController@delete')->before('mustBe:Administrator');
        Route::patch('/{first_collection_id}/merge/{second_collection_id}', 'CollectionsController@merge')->before('mustBe:Administrator');
    });
});