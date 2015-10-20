<?php
Route::group(array('prefix' => 'missioncontrol/objects', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => 'auth'), function() {
        Route::get('/{object_id}/comments', 'CommentsController@commentsForObject');
    });

    Route::group(array('middleware' => 'mustBe:Subscriber'), function() {
        Route::post('/{object_id}/comments/create', 'CommentsController@create');
        Route::delete('/{object_id}/comments/{comment_id}', 'CommentsController@delete');
        Route::patch('/{object_id}/comments/{comment_id}', 'CommentsController@edit');
    });
});