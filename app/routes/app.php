<?php

Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@home'
));

Route::get('/launchsite/{slug}', array(
    'as' => 'launchsite.get',
    'uses' => 'LaunchSiteController@get'
));