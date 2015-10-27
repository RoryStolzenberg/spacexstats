<?php
Route::group(array('prefix' => 'missioncontrol/objects', 'namespace' => 'MissionControl'), function() {

    Route::group(array('middleware' => ['mustBe:Subscriber', 'doesExist:Object']), function () {

        Route::get('/{object_id}/edit', 'ObjectsController@getEdit');
        Route::patch('/{object_id}/edit', 'ObjectsController@getEdit');

        Route::patch('/{object_id}/revert', 'ObjectsController@revert');

        Route::any('/{object_id}/note', 'ObjectsController@note');
        Route::any('/{object_id}/favorite', 'ObjectsController@favorite');
        Route::get('/{object_id}/download', 'ObjectsController@download');
    });

    Route::get('/{object_id}', 'ObjectsController@get')->before('doesExist:Object');
});
