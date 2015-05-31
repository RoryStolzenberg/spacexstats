<?php
Route::group(array('before' => 'mustBeLoggedIn'), function() {
    Route::get('missioncontrol/buy', array('as' => 'missionControl.buy', function() {
        return View::make('missionControl.buy', array(
            'title' => 'Misson Control',
            'currentPage' => 'mission-control-buy'
        ));
    }));

    Route::post('missioncontrol/buy', array(
        'as' => 'missionControl.buy',
        'uses' => 'PaymentController@purchase'
    ));

    Route::get('missioncontrol/buy/success', array(
        'as' => 'missionControl.buy.success',
        'uses' => 'PaymentController@success'
    ));
});

Route::group(array('before' => 'mustBe:Administrator'), function() {
    Route::get('missioncontrol/review', array(
        'as' => 'missionControl.review.index',
        'uses' => 'ReviewController@index'
    ));

    Route::get('missioncontrol/review/get', array(
        'as' => 'missionControl.review.get',
        'uses' => 'ReviewController@get'
    ));

    Route::post('missioncontrol/review/update/{object_id}', array(
        'as' => 'missionControl.review.update',
        'uses' => 'ReviewController@update'
    ));
});

Route::get('missioncontrol/about', array('as' => 'missionControl.about', function() {
    return View::make('missionControl.about', array(
        'title' => 'Misson Control',
        'currentPage' => 'mission-control-about'
    ));
}));

Route::group(array('before' => 'mustBe:Subscriber'), function() {
    Route::get('missioncontrol/create/retrieveTweet/{$id}', array(
        'as' => 'missionControl.create.retrieveTweet',
        'uses' => 'UploadController@retrieveTweet'
    ));

    Route::get('missioncontrol/create', array(
        'as' => 'missionControl.create',
        'uses' => 'UploadController@show'
    ));

    Route::post('missioncontrol/create/upload', array(
        'as' => 'missionControl.create.upload',
        'uses' => 'UploadController@upload'
    ));

    Route::post('missioncontrol/create/submit', array(
        'as' => 'missionControl.create.submit',
        'uses' => 'UploadController@submit'
    ));

    Route::get('missioncontrol/{object_id}', array(
        'as' => 'missionControl.get',
        'uses' => 'MissionControlController@get'
    ));
});

Route::get('missioncontrol', array(
    'as' => 'missionControl',
    'uses' => 'MissionControlController@home'
));
