<?php
Route::group(['prefix' => 'missioncontrol/tags', 'namespace' => 'MissionControl', 'middleware' => ['mustBe:Subscriber']], function() {
    Route::get('/', 'TagsController@all');

    Route::get('/{slug}', 'TagsController@get')->middleware('doesExist:Tag');
    Route::get('/{slug}/edit', 'TagsController@edit')->middleware('doesExist:Tag');
    Route::post('/{slug}/edit', 'TagsController@edit')->middleware('doesExist:Tag');
});