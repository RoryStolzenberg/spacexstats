<?php
Route::group(array('prefix' => 'missioncontrol/collections', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => 'mustBe:Subscriber'), function() {
        Route::get('/', 'CollectionsController@index');
        Route::get('/{collection_id}', 'CollectionsController@get');

        Route::put('/create', 'CollectionsController@create');
        Route::patch('/{collection_id}', 'CollectionsController@edit');

        Route::delete('/{collection_id}', 'CollectionsController@delete')->before('mustBe:Administrator');
    });
});