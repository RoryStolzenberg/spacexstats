<?php

Route::group(array('namespace' => 'Live'), function() {
    Route::get('live', 'LiveController@live');

    Route::group(array('middleware' => ['isLaunchController']), function() {

        Route::post('/live/send/create', 'LiveController@create');
        Route::delete('/live/send/destroy', 'LiveController@destroy');

        Route::post('live/send/message', 'LiveController@message');
        Route::patch('/live/send/message', 'LiveController@editMessage');

        Route::patch('live/send/details', 'LiveController@editDetails');

        Route::patch('/live/send/countdown/pause', 'LiveController@pauseCountdown');
        Route::patch('/live/send/countdown/resume', 'LiveController@resumeCountdown');

        Route::patch('live/send/cannedresponses', 'LiveController@editCannedResponses');
    });
});