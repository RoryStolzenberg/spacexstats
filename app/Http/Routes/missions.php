<?php
Route::group(array('prefix' => 'missions'), function() {
    Route::get('/future', 'MissionsController@future');

    Route::get('/past', 'MissionsController@past');

    Route::get('/all', 'MissionsController@all')->before('mustBe:Subscriber');

    Route::group(array('middleware' => 'mustBe:Administrator'), function() {
        Route::get('/create', 'MissionsController@getCreate');
        Route::post('/create', 'MissionsController@postCreate');

        Route::get('/{slug}/edit', 'MissionsController@getEdit')->before('doesExist:Mission');
        Route::post('/{slug}/edit', 'MissionsController@postEdit')->before('doesExist:Mission');
    });

    Route::get('/{slug}', 'MissionsController@get')->before('doesExist:Mission');

    Route::get('/{slug}/launchdatetime', 'MissionsController@launchDateTime')->before('doesExist:Mission');

    Route::get('/{slug}/telemetry', 'MissionsController@telemetry')->before(['mustBe:Subscriber', 'doesExist:Mission']);
    Route::get('/{slug}/raw', 'MissionsController@raw')->before(['mustBe:Subscriber', 'doesExist:Mission']);
});
