<?php
Route::group(array('prefix' => 'missioncontrol/objects'), function() {

    Route::group(array('before' => 'mustBeLoggedIn'), function() {

        Route::get('/{object_id}/comments', array(
            'as' => 'comments.get',
            'uses' => 'CommentsController@objectComments'
        ));

        Route::post('/{object_id}/comments/add', array(
            'as' => 'comments.add',
            'uses' => 'CommentsController@addComment'
        ));

        Route::delete('/{object_id}/comments/{comment_id}/delete', array(
            'as' => 'comments.delete',
            'uses' => 'CommentsController@deleteComment'
        ));

        Route::patch('/{object_id}/comments/{comment_id}/edit', array(
            'as' => 'comments.edit',
            'uses' => 'CommentsController@editComment'
        ));
    });
});