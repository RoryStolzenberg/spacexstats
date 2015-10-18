<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

function routesInDirectory($app = '') {
    $routeDir = app_path('Http/Routes/' . $app . ($app !== '' ? '/' : NULL));
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

/* MISCELLANEOUS ROUTES */
Route::get('webcast/getstatus', 'WebcastStatusController@getStatus');

Route::get('calendars/all', 'CalendarController@getAll');
Route::get('calendars/{slug}', 'CalendarController@get')->before('doesExist:Mission');

Route::post('faq/getquestions', 'QuestionsController@getQuestions');
Route::get('faq','QuestionsController@index');

Route::get('admin', 'AdminController@index')->before('mustBe:Administrator');

Route::get('newssummaries', 'NewsSummariesController@index');