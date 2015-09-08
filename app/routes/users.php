<?php
Route::group(array('prefix' => 'users'), function() {

    Route::group(array('before' => 'mustBeLoggedOut'), function() {
        Route::get('/signup', array(
            'as' => 'users.signup',
            'uses' => 'UsersController@create'
        ));

        Route::post('/signup', array(
            'as' => 'users.signup',
            'uses' => 'UsersController@create'
        ))->before('csrf');

        Route::any('/login', array(
            'as' => 'users.login',
            'uses' => 'UsersController@login'
        ));

        Route::get('/verify/{email}/{key}', array(
            'as' => 'users.verify',
            'uses' => 'UsersController@verify'
        ));
    });

    Route::group(array('before' => 'mustBeLoggedIn'), function() {
        Route::post('/logout', array(
            'as' => 'users.logout',
            'uses' => 'UsersController@logout'
        ));
    });

    Route::group(array('before' => 'mustBeYourself'), function() {
        Route::get('/{username}/edit', array(
            'as' => 'users.edit',
            'uses' => 'UsersController@edit'
        ));

        Route::post('/{username}/edit/profile', array(
            'as' => 'users.edit.profile',
            'uses' => 'UsersController@editProfile'
        ));

        Route::post('/{username}/edit/emailnotifications', array(
            'as' => 'users.edit.emailnotifications',
            'uses' => 'UsersController@editEmailNotifications'
        ));

        Route::post('/{username}/edit/smsnotifications', array(
            'as' => 'users.edit.smsnotifications',
            'uses' => 'UsersController@editSMSNotifications'
        ))->before('mustBe:Subscriber');

        Route::post('/{username}/edit/redditnotifications', array(
            'as' => 'users.edit.redditnotifications',
            'uses' => 'UsersController@editRedditNotifications'
        ))->before('mustBe:Subscriber');

        Route::get('/{username}/notes', array(
            'as' => 'users.profile.notes',
            'uses' => 'UsersController@notes'
        ));
    });

    Route::get('/{username}/uploads', array(
        'as' => 'users.profile.uploads',
        'uses' => 'UsersController@uploads'
    ));

    Route::get('/{username}/comments', array(
        'as' => 'users.profile.comments',
        'uses' => 'UsersController@comments'
    ));

    Route::get('/{username}/favorites', array(
        'as' => 'users.profile.favorites',
        'uses' => 'UsersController@favorites'
    ));

    Route::get('/{username}', array(
        'as' => 'users.get',
        'uses' => 'UsersController@get'
    ));
});
