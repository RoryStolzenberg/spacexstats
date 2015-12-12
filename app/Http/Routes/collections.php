<?php
Route::group(['prefix' => 'missioncontrol/collections', 'namespace' => 'MissionControl'], function() {

    Route::group(['middleware' => ['mustBe:Subscriber']], function() {
        Route::get('/', 'CollectionsController@index');

        Route::get('/mission/{slug}', 'CollectionsController@mission')->middleware('doesExist:Mission');
        Route::get('/{collection_id}', 'CollectionsController@get');

        Route::post('/create', 'CollectionsController@create');
        Route::patch('/{collection_id}', 'CollectionsController@edit');

        Route::delete('/{collection_id}', 'CollectionsController@delete')->middleware('mustBe:Administrator');
        Route::patch('/{first_collection_id}/merge/{second_collection_id}', 'CollectionsController@merge')->middleware('mustBe:Administrator');
    });
});