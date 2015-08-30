<?php
Route::get('missioncontrol/tags', array(
    'as' => 'tags.all',
    'uses' => 'TagsController@all'
))->before('mustBe:Subscriber');

Route::get('missioncontrol/tags/{slug}', array(
    'as' => 'tags.get',
    'uses' => 'TagsController@get'
))->before('doesTagExist|mustBe:subscriber');

Route::get('missioncontrol/tags/{slug}/edit', array(
    'as' => 'tags.edit',
    'uses' => 'TagsController@edit'
))->before('doesTagExist|mustBe:subscriber');

Route::post('missioncontrol/tags/{slug}/edit', array(
    'as' => 'tags.edit',
    'uses' => 'TagsController@edit'
))->before('doesTagExist|mustBe:subscriber');