<?php
Route::group(array('prefix' => 'auth'), function() {

    // Registration
    Route::get('/signup', 'AuthController@getSignUp');
    Route::post('/signup', 'AuthController@postSignUp');

    // Login
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', 'AuthController@postLogin');

    // Logout
    Route::post('/logout', 'AuthController@logout');

    // Forgot & Reset Password Functionality
    Route::get('/forgotpassword', 'UsersController@getForgotPassword');
    Route::post('/forgotpassword', 'UsersController@postForgotPassword');

    Route::get('/resetpassword/{username}/{key}', 'UsersController@getResetPassword');
    Route::post('/resetpassword/{username}/{key}', 'UsersController@postResetPassword');
});
