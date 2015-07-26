<?php
Route::get('missions/future', array(
    'as' => 'missions.future',
    'uses' => 'MissionsController@future'
));

Route::get('missions/past', array(
    'as' => 'missions.past',
    'uses' => 'MissionsController@past'
));

Route::get('missions/all', array(
    'as' => 'missions.all',
    'uses' => 'MissionsController@all'
));

Route::group(array('before' => 'mustBe:Administrator'), function() {
    Route::get('missions/create', array(
        'as' => 'missions.create',
        'uses' => 'MissionsController@create'
    ));

    Route::post('missions/create', array(
        'as' => 'missions.create',
        'uses' => 'MissionsController@create'
    ))->before('csrf');
});

Route::get('missions/{slug}', array(
    'as' => 'missions.get',
    'uses' => 'MissionsController@get'
))->before('doesMissionExist');

Route::get('missions/{slug}/edit', array(
    'as' => 'missions.edit',
    'uses' => 'MissionsController@edit'
))->before('doesMissionExist');

Route::get('missions/{slug}/requestlaunchdatetime', array(
    'as' => 'missions.requestLaunchDateTime',
    'uses' => 'MissionsController@requestLaunchDateTime'
))->before('doesMissionExist');

Route::get('missions/{slug}/raw', array(
    'as' => 'missions.raw',
    'uses' => 'MissionsController@raw'
))->before('mustBe:Subscriber|doesMissionExist');