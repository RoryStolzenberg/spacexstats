<?php
Route::group(array('prefix' => 'missioncontrol/objects'), function() {

    Route::group(array('before' => 'mustBe:Subscriber'), function () {

        Route::any('/{object_id}/edit', array(
            'as' => 'missionControl.objects.edit',
            'uses' => 'ObjectsController@edit'
        ))->before('doesObjectExist');

        Route::any('/{object_id}/note', array(
            'as' => 'missionControl.objects.note',
            'uses' => 'ObjectsController@note'
        ))->before('doesObjectExist');

        Route::any('/{object_id}/favorite', array(
            'as' => 'missionControl.objects.favorite',
            'uses' => 'ObjectsController@favorite'
        ));

        Route::get('/{object_id}/download', array(
            'as' => 'missionControl.objects.download',
            'uses' => 'ObjectsController@download'
        ));
    });

    Route::get('/{object_id}', array(
        'as' => 'missionControl.objects.get',
        'uses' => 'ObjectsController@get'
    ))->before('doesObjectExist');
});
