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
    return view('welcome');
});

route::get('/','TasksController@index')->name('tasks');
route::get('/search','TasksController@search')->name('tasks.search');
route::post('/','TasksController@store')->name('tasks.store');
route::put('/{id}','TasksController@update')->name('tasks.update');
route::get('/{id}','TasksController@show')->name('tasks.show');
route::delete('/{id}','TasksController@destroy')->name('tasks.destroy');
