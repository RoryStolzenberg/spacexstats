<?php

Route::group(array('namespace' => 'Live'), function() {
    Route::get('live', 'LiveController@live');

    Route::group(array('middleware' => ['isLaunchController', 'auth:isAdmin']), function() {

        Route::post('/live/send/create', 'LiveController@create');
        Route::delete('/live/send/destroy', 'LiveController@destroy');

        Route::post('live/send/message', 'LiveController@message');
        Route::patch('/live/send/message', 'LiveController@editMessage');

        Route::post('live/send/settings', 'LiveController@settings');
        Route::patch('live/send/settings', 'LiveController@editSettings');

        Route::patch('live/send/cannedResponses', 'LiveController@editCannedResponses');
    });
});