<?php
Route::group(array('prefix' => 'missioncontrol/dataviews'), function() {

    Route::group(array('before' => 'mustBeLoggedIn'), function() {

        Route::get('/{dataview_id}', array(
            'as' => 'missionControl.dataviews.get',
            'uses' => 'DataViewsController@get'
        ));

        Route::any('/create', array(
            'as' => 'missionControl.dataviews.create',
            'uses' => 'DataViewsController@create'
        ))->before('isAdmin');

        Route::any('/{dataview_id}/edit', array(
            'as' => 'missionControl.dataviews.edit',
            'uses' => 'DataViewsController@edit'
        ))->before('isAdmin');
    });
});