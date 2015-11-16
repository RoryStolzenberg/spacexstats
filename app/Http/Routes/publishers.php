<?php
Route::group(array('prefix' => 'missioncontrol/publishers', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => 'mustBe:Subscriber'), function() {

        Route::get('/{publisher_id}', 'PublishersController@get');

        Route::get('/create', 'PublishersController@getCreate');
        Route::post('/create', 'PublishersController@postCreate');

        Route::get('/{publisher_id}/edit', 'PublishersController@getEdit');
        Route::patch('/{publisher_id}/edit', 'PublishersController@patchEdit');
    });
});