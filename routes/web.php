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


// User profile
Route::group(['middleware' => [
    \App\Http\Middleware\UserProfileSlugRedirect::class,
]], function () {
    Route::get('/u/{profile}', 'Web\UserController@show')
        ->name(\App\Http\Controllers\Web\UserController::SHOW_PATH_NAME);

    Route::get('/u/{profile}/comments', 'Web\UserController@comments')
        ->name(\App\Http\Controllers\Web\UserController::COMMENTS_PATH_NAME);


    // Private tabs
    Route::get('/u/{profile}/drafts', 'Web\UserController@drafts')
        ->name(\App\Http\Controllers\Web\UserController::DRAFTS_PATH_NAME);

    Route::get('/u/{profile}/bookmarks', 'Web\BookmarkController@index')
        ->name(\App\Http\Controllers\Web\BookmarkController::INDEX_PATH_NAME);

    Route::get('/u/{profile}/post_likes', 'Web\PostLikeController@index')
        ->name(\App\Http\Controllers\Web\PostLikeController::INDEX_PATH_NAME);

    Route::get('/u/{profile}/post_dislikes', 'Web\PostDislikeController@index')
        ->name(\App\Http\Controllers\Web\PostDislikeController::INDEX_PATH_NAME);
});



// Comments
Route::post('/comments/{postId}/store', 'Web\CommentController@store')
    ->name(\App\Http\Controllers\Web\CommentController::STORE_PATH_NAME);

//Route::get('/comments/load_responses/{commentId}', 'Web\CommentController@loadResponses')
//    ->name(\App\Http\Controllers\Web\CommentController::LOAD_RESPONSES_PATH_NAME);


// Bookmarks
// FIXME correct rest path names and request types
Route::post('/bookmarks/store', 'Web\BookmarkController@store')
    ->name(\App\Http\Controllers\Web\BookmarkController::STORE_PATH_NAME);

Route::post('/bookmarks/destroy/', 'Web\BookmarkController@destroy')
    ->name(\App\Http\Controllers\Web\BookmarkController::DESTROY_PATH_NAME);


// Likes
Route::post('/post_likes/store', 'Web\PostLikeController@store')
    ->name(\App\Http\Controllers\Web\PostLikeController::STORE_PATH_NAME);

Route::post('/post_likes/destroy/', 'Web\PostLikeController@destroy')
    ->name(\App\Http\Controllers\Web\PostLikeController::DESTROY_PATH_NAME);


// Dislikes
Route::post('/post_dislikes/store', 'Web\PostDislikeController@store')
    ->name(\App\Http\Controllers\Web\PostDislikeController::STORE_PATH_NAME);

Route::post('/post_dislikes/destroy/', 'Web\PostDislikeController@destroy')
    ->name(\App\Http\Controllers\Web\PostDislikeController::DESTROY_PATH_NAME);


// Posts
Route::get('/a/{article}', 'Web\PostController@show')
    ->name(\App\Http\Controllers\Web\PostController::SHOW_PATH_NAME);

Route::get('/new', 'Web\PostController@newArticles')
    ->name(\App\Http\Controllers\Web\PostController::NEW_PATH_NAME);

Route::get('/top/{timeframe?}/', 'Web\PostController@topArticles')
    ->name(\App\Http\Controllers\Web\PostController::TOP_PATH_NAME);


// Tags
Route::get('/tags/{tag}/{timeframe?}', 'Web\TagController@show')
    ->name(\App\Http\Controllers\Web\TagController::SHOW_PATH_NAME);


// Reports
Route::post('/abuse_requests', 'Web\AbuseRequestController@store')
    ->name(\App\Http\Controllers\Web\AbuseRequestController::STORE_PATH_NAME);



// Categories
Route::get('/{category}/{timeframe?}', 'Web\CategoryController@show')
    ->name(\App\Http\Controllers\Web\CategoryController::SHOW_PATH_NAME);

