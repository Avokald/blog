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


// Users
Route::get('/u/{profile}', 'Web\UserController@show')
    ->name(\App\Http\Controllers\Web\UserController::SHOW_PATH_NAME);

Route::get('/u/{profile}/drafts', 'Web\UserController@drafts')
    ->name(\App\Http\Controllers\Web\UserController::DRAFTS_PATH_NAME);


// Bookmarks
Route::get('/u/{profile}/bookmarks', 'Web\BookmarkController@index')
    ->name(\App\Http\Controllers\Web\BookmarkController::INDEX_PATH_NAME);

Route::post('/bookmarks/store', 'Web\BookmarkController@store')
    ->name(\App\Http\Controllers\Web\BookmarkController::STORE_PATH_NAME);

Route::post('/bookmarks/destroy/', 'Web\BookmarkController@destroy')
    ->name(\App\Http\Controllers\Web\BookmarkController::DESTROY_PATH_NAME);






// Posts
Route::get('/a/{article}', 'Web\PostController@show')
    ->name(\App\Http\Controllers\Web\PostController::SHOW_PATH_NAME);

Route::get('/new', 'Web\PostController@newArticles')
    ->name(\App\Http\Controllers\Web\PostController::NEW_PATH_NAME);

Route::get('/top/{timeframe?}/', 'Web\PostController@topArticles')
    ->name(\App\Http\Controllers\Web\PostController::TOP_PATH_NAME);


// Tags
Route::get('/tag/{tag}/{timeframe?}', 'Web\TagController@show')
    ->name(\App\Http\Controllers\Web\TagController::SHOW_PATH_NAME);






// Categories
Route::get('/{category}/{timeframe?}', 'Web\CategoryController@show')
    ->name(\App\Http\Controllers\Web\CategoryController::SHOW_PATH_NAME);

