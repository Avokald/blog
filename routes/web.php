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
Route::group(['prefix' => '/api/v1/'], function () {
    Route::get('/home', 'HomeController@index')->name('home');


    // User profile
    Route::group([], function () {
        Route::get('/users/{sluggedId}', 'Web\UserController@show')
            ->name(\App\Http\Controllers\Web\UserController::SHOW_PATH_NAME);

        Route::get('/users/{sluggedId}/top/{timeframe}', 'Web\UserController@top')
            ->name(\App\Http\Controllers\Web\UserController::TOP_PATH_NAME);

        Route::get('/users/{sluggedId}/comments', 'Web\UserController@comments')
            ->name(\App\Http\Controllers\Web\UserController::COMMENTS_PATH_NAME);


        // Private
        Route::group([
            'middleware' => [
                \App\Http\Middleware\UserLoggedIn::class,
                \App\Http\Middleware\UserProfileRestricted::class,
            ]
        ], function () {
            Route::get('/users/{sluggedId}/drafts', 'Web\UserController@drafts')
                ->name(\App\Http\Controllers\Web\UserController::DRAFTS_PATH_NAME);

            Route::get('/users/{sluggedId}/bookmarks/posts', 'Web\BookmarkController@index')
                ->name(\App\Http\Controllers\Web\BookmarkController::INDEX_PATH_NAME);

            Route::get('/users/{sluggedId}/post_likes', 'Web\PostLikeController@index')
                ->name(\App\Http\Controllers\Web\PostLikeController::INDEX_PATH_NAME);

            Route::get('/users/{sluggedId}/post_dislikes', 'Web\PostDislikeController@index')
                ->name(\App\Http\Controllers\Web\PostDislikeController::INDEX_PATH_NAME);
        });
    });


    // Posts
    Route::get('/posts/{slugged_id}', 'Web\PostController@show')
        ->name(\App\Http\Controllers\Web\PostController::SHOW_PATH_NAME);

    Route::post('/posts', 'Web\PostController@store')
        ->name(\App\Http\Controllers\Web\PostController::STORE_PATH_NAME);

    Route::get('/page/new', 'Web\PostController@newArticles')
        ->name(\App\Http\Controllers\Web\PostController::NEW_PATH_NAME);

    Route::get('/page/top/{timeframe?}/', 'Web\PostController@topArticles')
        ->name(\App\Http\Controllers\Web\PostController::TOP_PATH_NAME);


    // Comments
    Route::post('/comments/{postId}', 'Web\CommentController@store')
        ->name(\App\Http\Controllers\Web\CommentController::STORE_PATH_NAME);

    //Route::get('/comments/load_responses/{commentId}', 'Web\CommentController@loadResponses')
    //    ->name(\App\Http\Controllers\Web\CommentController::LOAD_RESPONSES_PATH_NAME);


    // Bookmarks
    // FIXME correct rest path names and request types
    Route::post('/bookmarks', 'Web\BookmarkController@store')
        ->name(\App\Http\Controllers\Web\BookmarkController::STORE_PATH_NAME);

    Route::delete('/bookmarks', 'Web\BookmarkController@destroy')
        ->name(\App\Http\Controllers\Web\BookmarkController::DESTROY_PATH_NAME);


    // Likes
    Route::post('/post_likes', 'Web\PostLikeController@store')
        ->name(\App\Http\Controllers\Web\PostLikeController::STORE_PATH_NAME);

    Route::delete('/post_likes', 'Web\PostLikeController@destroy')
        ->name(\App\Http\Controllers\Web\PostLikeController::DESTROY_PATH_NAME);


    // Dislikes
    Route::post('/post_dislikes', 'Web\PostDislikeController@store')
        ->name(\App\Http\Controllers\Web\PostDislikeController::STORE_PATH_NAME);

    Route::delete('/post_dislikes', 'Web\PostDislikeController@destroy')
        ->name(\App\Http\Controllers\Web\PostDislikeController::DESTROY_PATH_NAME);


    // Tags
    Route::get('/tags/{tag}/{timeframe?}', 'Web\TagController@show')
        ->name(\App\Http\Controllers\Web\TagController::SHOW_PATH_NAME);


    // Abuse requests
    Route::get('/abuse_requests', 'Web\AbuseRequestController@index')
        ->name(\App\Http\Controllers\Web\AbuseRequestController::INDEX_PATH_NAME);

    Route::post('/abuse_requests', 'Web\AbuseRequestController@store')
        ->name(\App\Http\Controllers\Web\AbuseRequestController::STORE_PATH_NAME);


    // Categories
    Route::get('/categories/{category}/{timeframe?}', 'Web\CategoryController@show')
        ->name(\App\Http\Controllers\Web\CategoryController::SHOW_PATH_NAME);

    // TODO Refactor into separate controller
    Route::get('/metadata', function () {
        return [
            'user' => request()->user(),
        ];
    });

    Route::get('/misc/users', function () {
        return \App\Models\User::all();
    });

    Route::get('/misc/categories', function () {
        return \App\Models\Category::all();
    });

    Route::get('/misc/tags', function () {
        return \App\Models\Tag::all();
    });

    Route::get('/test', function () {
        return view('home');
    });
});

// TODO Later
//Route::get('/elastic', function () {
//    $hosts = [
//        'es01:9200',
//    ];
//
//    $client = \Elasticsearch\ClientBuilder::create()
//        ->setHosts($hosts)
//        ->build();
//
//    $params = [
//        'index' => 'my_index',
//        'id' => 'my_id',
//        'body' => ['testField' => 'abc'],
//    ];
//
//    $response = $client->index($params);
//
//    dd($response);
//});
//
//Route::get('/el', function () {
//    $hosts = [
//        'es01:9200',
//    ];
//
//    $client = \Elasticsearch\ClientBuilder::create()
//        ->setHosts($hosts)
//        ->build();
//
//    $params = [
//        'index' => 'my_index',
//        'body' => [
//            'query' => [
//                'match' => [
//                    'testField' => 'abc',
//                ],
//            ],
//        ],
//    ];
//
//    $response = $client->search($params);
//
//    dd($response);
//
//});

Route::get('/metrics', function () {
    $registry = new \Prometheus\Storage\Redis([
        'host' => 'redis1',
    ]);

    $renderer = new \Prometheus\RenderTextFormat();
    $result = $renderer->render($registry->collect());

    header('Content-type: ' . \Prometheus\RenderTextFormat::MIME_TYPE);
    return $result;
});

Auth::routes();

Route::get('/{path?}', function (?string $path = null) {
    return view('welcome');
})->where('path', '.*');
