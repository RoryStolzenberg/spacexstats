<?php
Route::get('/locations/getLocationData', array(
    'as' => 'locations.getLocationData',
    'uses' => 'LocationsController@getLocationData'
));

Route::get('/locations', array(
    'as' => 'locations',
    'uses' => 'LocationsController@home'
));