<?php
Route::group(array('prefix' => 'missioncontrol/tags', 'namespace' => 'MissionControl'), function() {
    Route::get('/', array(
        'as' => 'tags.all',
        'uses' => 'TagsController@all'
    ))->before('mustBe:Subscriber');

    Route::get('/{slug}', array(
        'as' => 'tags.get',
        'uses' => 'TagsController@get'
    ))->before('doesTagExist|mustBe:Subscriber');

    Route::get('/{slug}/edit', array(
        'as' => 'tags.edit',
        'uses' => 'TagsController@edit'
    ))->before('doesTagExist|mustBe:Subscriber');

    Route::post('/{slug}/edit', array(
        'as' => 'tags.edit',
        'uses' => 'TagsController@edit'
    ))->before('doesTagExist|mustBe:Subscriber');
});