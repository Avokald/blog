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

        return [
            'user' => $user,
            'liked_posts' => $user->getLikedPostsId() ?? [],
            'disliked_posts' => $user->getDislikedPostsId() ?? [],
            'bookmarked_posts' => $user->getBookmarkedPostsId() ?? [],
        ];
    }

}
