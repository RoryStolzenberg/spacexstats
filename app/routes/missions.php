<?php
Route::group(array('prefix' => 'missions'), function() {
    Route::get('/future', array(
        'as' => 'missions.future',
        'uses' => 'MissionsController@future'
    ));

    Route::get('/past', array(
        'as' => 'missions.past',
        'uses' => 'MissionsController@past'
    ));

    Route::get('/all', array(
        'as' => 'missions.all',
        'uses' => 'MissionsController@all'
    ))->before('mustBe:Subscriber');

    Route::group(array('before' => 'mustBe:Administrator'), function() {
        Route::get('/create', array(
            'as' => 'missions.create',
            'uses' => 'MissionsController@create'
        ));

        Route::post('/create', array(
            'as' => 'missions.create',
            'uses' => 'MissionsController@create'
        ))->before('csrf');
    });

    Route::get('/{slug}', array(
        'as' => 'missions.get',
        'uses' => 'MissionsController@get'
    ))->before('doesMissionExist');

    Route::get('/{slug}/edit', array(
        'as' => 'missions.edit',
        'uses' => 'MissionsController@edit'
    ))->before('doesMissionExist');

    Route::get('/{slug}/requestlaunchdatetime', array(
        'as' => 'missions.requestLaunchDateTime',
        'uses' => 'MissionsController@requestLaunchDateTime'
    ))->before('doesMissionExist');

    Route::get('/{slug}/raw', array(
        'as' => 'missions.raw',
        'uses' => 'MissionsController@raw'
    ))->before('mustBe:Subscriber|doesMissionExist');
});
