<?php
Route::group(array('prefix' => 'users'), function() {

    Route::group(['middleware' => ['mustBe:Yourself']], function() {

        // Main edit functionality
        Route::get('/{username}/edit', 'UsersController@getEdit');
        Route::patch('/{username}/edit', 'UsersController@patchEditProfile');

        // Individual edit functionality
        Route::patch('/{username}/edit/emailnotifications', 'UsersController@editEmailNotifications');
        Route::patch('/{username}/edit/smsnotifications', 'UsersController@editSMSNotifications')->middleware('mustBe:Subscriber');
        Route::patch('/{username}/edit/redditnotifications', 'UsersController@editRedditNotifications')->middleware('mustBe:Subscriber');

        Route::get('/{username}/notes', 'UsersController@notes');
    });

    Route::get('/{username}/uploads', 'UsersController@uploads');
    Route::get('/{username}/comments', 'UsersController@comments');
    Route::get('/{username}/favorites', 'UsersController@favorites');

    Route::get('/{username}', 'UsersController@get');
});
