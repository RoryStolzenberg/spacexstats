<?php
Route::group(array('prefix' => 'missioncontrol/publishers', 'namespace' => 'MissionControl'), function() {

    Route::group(['middleware' => ['mustBe:Subscriber']], function() {

        Route::get('/', 'PublishersController@index');
        Route::get('/{publisher_id}', 'PublishersController@get');
        Route::post('/create', 'PublishersController@create');
        Route::patch('/{publisher_id}', 'PublishersController@edit');

        Route::delete('/{publisher_id}', 'PublishersController@delete')->middleware('mustBe:Administrator');
    });
});