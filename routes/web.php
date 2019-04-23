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
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');
    $router->get('/refresh', 'AuthController@refresh');
    $router->get('/me', 'AuthController@me');
});

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->post('create', 'UserController@store');
    $router->put('update/{id}', 'UserController@update');
    $router->get('{id}', 'UserController@show');
    $router->get('verify/{first_name}/{last_name}/{token}', 'UserController@verify');
    $router->post('forgot', 'UserController@forgotPassword');
    $router->post('reset', 'UserController@resetPassword');
    $router->delete('{id}', 'UserController@destroy');
});

$router->group(['prefix' => 'terms'], function () use ($router) {
    $router->get('', 'TermController@index');
    $router->get('/search/{term}', 'TermController@search');
});