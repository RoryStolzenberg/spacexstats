<?php
Route::get('/tags/all', array(
    'as' => 'tags.all',
    'uses' => 'TagsController@all'
))->before('mustBe:subscriber');
