<?php
Route::group(['prefix' => 'missioncontrol', 'namespace' => 'MissionControl'], function() {

    Route::group(['middleware' => 'auth'], function() {

        Route::get('/create/retrievetweet', 'UploadController@retrieveTweet');
        Route::get('/create/retrieveredditcomment', 'UploadController@retrieveRedditComment');

        Route::get('/success', 'PaymentController@success');
    });

    Route::group(['middleware' => 'mustBe:Administrator'], function() {
        Route::get('/review', 'ReviewController@index');
        Route::get('/review/get', 'ReviewController@get');
        Route::post('/review/update/{object_id}', 'ReviewController@update')->before('doesExist:Object');
    });

    Route::get('/about', function() {
        return View::make('missionControl.about');
    });

    Route::group(['middleware' => 'mustBe:Subscriber'], function() {

        Route::get('/fetch', 'MissionControlController@fetch');

        Route::post('/search', 'SearchController@search');
        Route::get('/search/fetch', 'SearchController@fetch');

        Route::get('/create', 'UploadController@show');
        Route::post('/create/upload', 'UploadController@upload');
        Route::post('/create/submit', 'UploadController@submit');
    });

    Route::get('/', 'MissionControlController@home');
});

