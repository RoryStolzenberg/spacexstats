<?php
Route::group(['prefix' => 'missioncontrol', 'namespace' => 'MissionControl'], function() {

    Route::group(['middleware' => 'auth'], function() {

        Route::get('/create/retrievetweet', 'UploadController@retrieveTweet');
        Route::get('/create/retrieveredditcomment', 'UploadController@retrieveRedditComment');

    });

    Route::group(['middleware' => ['mustBe:Administrator']], function() {
        Route::get('/review', 'ReviewController@index');
        Route::get('/review/get', 'ReviewController@get');
        Route::post('/review/update/{object_id}', 'ReviewController@update')->middleware(['doesExist:Object']);
    });

    Route::get('/about', 'MissionControlController@about');

    Route::group(['middleware' => 'mustBe:Subscriber'], function() {

        Route::post('/search', 'SearchController@search');
        Route::get('/search/fetch', 'SearchController@fetch');

        Route::get('/create', 'UploadController@show');
        Route::post('/create/upload', 'UploadController@upload');

        Route::put('/create/submit/files', 'UploadController@submitFiles');
        Route::put('/create/submit/post', 'UploadController@submitPost');
        Route::put('/create/submit/writing', 'UploadController@submitWriting');
    });

    Route::get('/', 'MissionControlController@home');
});

