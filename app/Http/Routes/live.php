<?php

Route::group(array('namespace' => 'Live'), function() {
    Route::get('live', 'LiveController@live');

    Route::group(array('middleware' => 'isLaunchController'), function() {

        Route::post('/live/send/create', 'LiveController@create');
        Route::post('/live/send/destroy', 'LiveController@destroy');
        Route::post('live/send/message', 'LiveController@message');
        Route::post('live/send/settings', 'LiveController@settings');

    });
});