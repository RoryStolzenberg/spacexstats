<?php
Route::group(array('prefix' => 'missioncontrol/objects'), function() {

    Route::group(array('before' => 'mustBeLoggedIn'), function() {

        Route::get('/{object_id}/comments', array(
            'as' => 'comments.get',
            'uses' => 'CommentsController@comments'
        ));
    });

});