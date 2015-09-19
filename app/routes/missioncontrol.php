<?php
Route::group(array('prefix' => 'missioncontrol'), function() {

    Route::group(array('before' => 'mustBeLoggedIn'), function() {

        Route::get('/create/retrievetweet/{id}', array(
            'as' => 'missionControl.create.retrieveTweet',
            'uses' => 'UploadController@retrieveTweet'
        ));

        Route::get('/create/retrieveredditcomment', array(
            'as' => 'missionControl.create.retrieveRedditComment',
            'uses' => 'UploadController@retrieveRedditComment'
        ));

        Route::get('/buy', array('as' => 'missionControl.buy', function() {
            return View::make('missionControl.buy', array(
                'title' => 'Misson Control',
                'currentPage' => 'mission-control-buy'
            ));
        }));

        Route::post('/buy', array(
            'as' => 'missionControl.buy',
            'uses' => 'PaymentController@purchase'
        ));

        Route::get('/buy/success', array(
            'as' => 'missionControl.buy.success',
            'uses' => 'PaymentController@success'
        ));
    });

    Route::group(array('before' => 'mustBe:Administrator'), function() {
        Route::get('/review', array(
            'as' => 'missionControl.review.index',
            'uses' => 'ReviewController@index'
        ));

        Route::get('/review/get', array(
            'as' => 'missionControl.review.get',
            'uses' => 'ReviewController@get'
        ));

        Route::post('/review/update/{object_id}', array(
            'as' => 'missionControl.review.update',
            'uses' => 'ReviewController@update'
        ))->before('doesObjectExist');
    });

    Route::get('/about', array('as' => 'missionControl.about', function() {
        return View::make('missionControl.about', array(
            'title' => 'Misson Control',
            'currentPage' => 'mission-control-about'
        ));
    }));

    Route::group(array('before' => 'mustBe:Subscriber'), function() {

        Route::get('/search', array(
            'as' => 'missionControl.search',
            'uses' => 'SearchController@search'
        ));

        Route::get('/create', array(
            'as' => 'missionControl.create',
            'uses' => 'UploadController@show'
        ));

        Route::post('/create/upload', array(
            'as' => 'missionControl.create.upload',
            'uses' => 'UploadController@upload'
        ));

        Route::post('/create/submit', array(
            'as' => 'missionControl.create.submit',
            'uses' => 'UploadController@submit'
        ));
    });

    Route::get('/', array(
        'as' => 'missionControl',
        'uses' => 'MissionControlController@home'
    ));
});

