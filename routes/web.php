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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/u/{profile}', 'Web\UserController@show')->name(\App\Http\Controllers\Web\UserController::SHOW_PATH_NAME);

Route::get('/a/{article}',
    'Web\ArticleController@show')->name(\App\Http\Controllers\Web\ArticleController::SHOW_PATH_NAME);