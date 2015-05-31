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

Route::any('/users/{username}/edit', array(
    'as' => 'users.edit',
    'uses' => 'UsersController@edit'
))->before('mustBeYourself');

Route::get('/users/{username}', array(
    'as' => 'users.get',
    'uses' => 'UsersController@get'
));