<?php
Route::group(array('before' => 'mustBeLoggedOut'), function() {
    Route::get('/users/signup', array(
        'as' => 'users.signup',
        'uses' => 'UsersController@create'
    ));

    Route::post('/users/signup', array(
        'as' => 'users.signup',
        'uses' => 'UsersController@create'
    ))->before('csrf');

    Route::any('/users/login', array(
        'as' => 'users.login',
        'uses' => 'UsersController@login'
    ));

    Route::get('/users/verify/{email}/{key}', array(
        'as' => 'users.verify',
        'uses' => 'UsersController@verify'
    ));
});

Route::group(array('before' => 'mustBeLoggedIn'), function() {
    Route::post('/users/logout', array(
        'as' => 'users.logout',
        'uses' => 'UsersController@logout'
    ));
});

Route::group(array('before' => 'mustBeYourself'), function() {
    Route::get('/users/{username}/edit', array(
        'as' => 'users.edit',
        'uses' => 'UsersController@edit'
    ));

    Route::post('/users/{username}/edit/profile', array(
        'as' => 'users.edit.profile',
        'uses' => 'UsersController@editProfile'
    ));

    Route::post('/users/{username}/edit/emailnotifications', array(
        'as' => 'users.edit.emailnotifications',
        'uses' => 'UsersController@editEmailNotifications'
    ));

    Route::post('/users/{username}/edit/smsnotifications', array(
        'as' => 'users.edit.smsnotifications',
        'uses' => 'UsersController@editSMSNotifications'
    ));

    Route::post('/users/{username}/edit/redditnotifications', array(
        'as' => 'users.edit.redditnotifications',
        'uses' => 'UsersController@editRedditNotifications'
    ));
});


Route::get('/users/{username}', array(
    'as' => 'users.get',
    'uses' => 'UsersController@get'
));