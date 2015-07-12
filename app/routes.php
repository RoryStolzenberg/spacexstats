<?php

function routesInDirectory($app = '') {
    $routeDir = app_path('routes/' . $app . ($app !== '' ? '/' : NULL));
    $iterator = new RecursiveDirectoryIterator($routeDir);
    $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($iterator as $route) {
        $isDotFile = strpos($route->getFilename(), '.') === 0;

        if (!$isDotFile && !$route->isDir()) {
            require $routeDir . $route->getFilename();
        }
    }
}

routesInDirectory();

Route::get('webcast/getstatus', array(
    'as' => 'webcast.getStatus',
    'uses' => 'WebcastStatusController@getStatus'
));

Route::get('calendars/all', array(
	'as' => 'calendars.getAll',
	'uses' => 'CalendarController@getAll'
));

Route::get('calendars/{slug}', array(
	'as' => 'calendars.get',
	'uses' => 'CalendarController@get'
))->before('doesMissionExist');

Route::post('faq/getquestions', array(
	'as' => 'faq.getquestions',
	'uses' => 'QuestionsController@getQuestions'
));

Route::get('faq', array(
	'as' => 'faq',
	'uses' => 'QuestionsController@index'
));

Route::get('admin', array(
    'as' => 'admin',
    'uses' => 'AdminController@index'
))->before('mustBe:Administrator');
