<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('projects', 'ProjectsController', ['names' => ['index' => 'home']]);
    Route::resource('users', 'UsersController');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');

    Route::post('/users/{user}/avatar', 'UserAvatarController@store');

    //Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes(['register' => false]);
