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

/* MISCELLANEOUS ROUTES */
Route::get('live', array(
    'as' => 'live',
    'uses' => 'LiveController@live'
));

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

/* CONTROLLERS */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
