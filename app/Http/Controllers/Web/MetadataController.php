<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class MetadataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const INDEX_PATH_NAME = 'metadata';
    public function index() : array
    {
        $user = request()->user();
        $likes = [];
        $dislikes = [];
        $bookmarks = [];

        if ($user !== null) {
            // Queries to only get post_id's instead of the whole models and their relations
            $likes = \Illuminate\Support\Facades\DB::select('SELECT post_id FROM post_likes WHERE user_id = ?',
                [$user->id]);
            $dislikes = \Illuminate\Support\Facades\DB::select('SELECT post_id FROM post_dislikes WHERE user_id = ?',
                [$user->id]);

            // Map results into a simple array otherwise they are objects that contain one property - post_id

            $likes = array_map(function ($like) {
                return $like->post_id;
            }, $likes);

            $dislikes = array_map(function ($dislike) {
                return $dislike->post_id;
            }, $dislikes);
        }

        return [
            'user' => $user,
            'liked_posts' => $likes,
            'disliked_posts' => $dislikes,
            'bookmarked_posts' => $user->getBookmarkedPostsId(),
        ];
    }

}
