<?php

Route::get('live', 'LiveController@live');

Route::group(array('middleware' => 'isLaunchController'), function() {

    Route::post('live/update', 'LiveController@update');
    Route::post('live/update/settings', 'LiveController@updateSettings');

});
