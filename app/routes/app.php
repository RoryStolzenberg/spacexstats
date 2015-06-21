<?php

Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@home'
));

Route::get('/locations', array(
    'as' => 'locations',
    'uses' => 'LocationsController@locations'
));