<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "Welcome To GluMob Tech Challenge. Version (". $router->app->version() . ")";
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('tasks',  ['uses' => 'TaskController@showAllTasks']);

    $router->get('tasks/{id}', ['uses' => 'TaskController@showOneTask']);

    $router->post('tasks', ['uses' => 'TaskController@create']);

    $router->delete('tasks/{id}', ['uses' => 'TaskController@delete']);

    $router->put('tasks/{id}', ['uses' => 'TaskController@update']);

    $router->get('processor', ['uses' => 'TaskController@getAverageProcessing']);
});

