<?php
Route::get('missioncontrol/create/retrievetweet/{id}', array(
    'as' => 'missionControl.create.retrieveTweet',
    'uses' => 'UploadController@retrieveTweet'
));

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
    ))->before('doesObjectExist');
});

Route::get('missioncontrol/about', array('as' => 'missionControl.about', function() {
    return View::make('missionControl.about', array(
        'title' => 'Misson Control',
        'currentPage' => 'mission-control-about'
    ));
}));

Route::group(array('before' => 'mustBe:Subscriber'), function() {

    Route::get('missioncontrol/search', array(
        'as' => 'missionControl.search',
        'uses' => 'SearchController@search'
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

    Route::any('missioncontrol/objects/{object_id}/note', array(
        'as' => 'missionControl.objects.note',
        'uses' => 'ObjectsController@note'
    ));

    Route::any('missioncontrol/objects/{object_id}/favorite', array(
        'as' => 'missionControl.objects.favorite',
        'uses' => 'ObjectsController@favorite'
    ));
});

Route::get('missioncontrol/objects/{object_id}', array(
    'as' => 'missionControl.objects.get',
    'uses' => 'ObjectsController@get'
))->before('doesObjectExist');

Route::get('missioncontrol', array(
    'as' => 'missionControl',
    'uses' => 'MissionControlController@home'
));
