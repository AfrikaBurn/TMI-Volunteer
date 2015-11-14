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

// Home page
Route::get('/', 'PageController@home');

// User authentication routes
Route::get('/register', 'PageController@view');
Route::get('/login', 'PageController@view');
Route::get('/logout', 'UserController@logout');

Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@login');

// Event routes
Route::get('/event', 'EventController@createForm');
Route::post('/event', 'EventController@create');

Route::get('/event/{event}/edit', 'EventController@editForm');
Route::post('/event/{event}/edit', 'EventController@edit');

Route::get('/event/{event}/delete', 'EventController@deleteForm');
Route::post('/event/{event}/delete', 'EventController@delete');

Route::get('/event/{event}', 'EventController@view');
