<?php
Route::group(array('prefix' => 'missions'), function() {
    Route::get('/future', 'MissionsController@allFutureMissions');
    Route::get('/past', 'MissionsController@allPastMissions');

    Route::group(array('middleware' => 'mustBe:Administrator'), function() {
        Route::get('/create', 'MissionsController@getCreate');
        Route::post('/create', 'MissionsController@postCreate');

        Route::get('/{slug}/edit', 'MissionsController@getEdit')->before('doesExist:Mission');
        Route::patch('/{slug}/edit', 'MissionsController@patchEdit')->before('doesExist:Mission');
    });

    Route::get('/{slug}', 'MissionsController@get')->before('doesExist:Mission');

    Route::get('/{slug}/launchdatetime', 'MissionsController@launchDateTime')->before('doesExist:Mission');

    Route::get('/{slug}/telemetry', 'MissionsController@telemetry')->before(['mustBe:Subscriber', 'doesExist:Mission']);
    Route::get('/{slug}/raw', 'MissionsController@raw')->before(['mustBe:Subscriber', 'doesExist:Mission']);
});
