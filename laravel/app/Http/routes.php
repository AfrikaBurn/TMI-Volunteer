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
Route::get('/event/{event}/grid', 'EventController@viewGrid');


// Department routes
Route::get('/event/{event}/department', 'DepartmentController@createForm');
Route::post('/department', 'DepartmentController@create');

Route::get('/department/{department}/edit', 'DepartmentController@editForm');
Route::post('/department/{department}/edit', 'DepartmentController@edit');

Route::get('/department/{department}/delete', 'DepartmentController@deleteForm');
Route::post('/department/{department}/delete', 'DepartmentController@delete');


// Shift routes
Route::get('/event/{event}/shift', 'ShiftController@createForm');
Route::post('/shift', 'ShiftController@create');

Route::get('/shift/{shift}/edit', 'ShiftController@editForm');
Route::post('/shift/{shift}/edit', 'ShiftController@edit');

Route::get('/shift/{shift}/delete', 'ShiftController@deleteForm');
Route::post('/shift/{shift}/delete', 'ShiftController@delete');


// Slot routes
Route::get('/slot/{slot}/take', 'SlotController@takeForm');
Route::post('/slot/{slot}/take', 'SlotController@take');

Route::get('/slot/{slot}/release', 'SlotController@releaseForm');
Route::post('/slot/{slot}/release', 'SlotController@release');


// User profile routes
Route::get('/profile', 'ProfileController@view');
Route::get('/profile/shifts', 'ProfileController@shifts');

Route::get('/profile/edit', 'ProfileController@editForm');
Route::post('/profile/edit', 'ProfileController@edit');

Route::get('/profile/upload', 'ProfileController@uploadForm');
Route::post('/profile/upload', 'ProfileController@upload');

