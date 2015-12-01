<?php
Route::group(['prefix' => 'missions'], function() {
    Route::get('/future', 'MissionsController@allFutureMissions');
    Route::get('/past', 'MissionsController@allPastMissions');

    Route::get('/all', 'MissionsController@all');

    Route::group(['middleware' => 'mustBe:Administrator'], function() {
        Route::get('/create', 'MissionsController@getCreate');
        Route::post('/create', 'MissionsController@postCreate');

        Route::get('/{slug}/edit', 'MissionsController@getEdit')->before('doesExist:Mission');
        Route::patch('/{slug}/edit', 'MissionsController@patchEdit')->before('doesExist:Mission');
    });

    Route::get('/{slug}', 'MissionsController@get')->before('doesExist:Mission');

    Route::get('/{slug}/launchdatetime', 'MissionsController@launchDateTime')->before('doesExist:Mission');

    Route::get('/{slug}/telemetry', 'MissionsController@telemetry')->before('doesExist:Mission');

    Route::group(['middleware' => ['mustBe:Subscriber', 'doesExist:Mission']], function() {
        Route::get('/{slug}/orbitalelements', 'MissionsController@orbitalElements');
        Route::get('/{slug}/raw', 'MissionsController@raw');
    });

});
