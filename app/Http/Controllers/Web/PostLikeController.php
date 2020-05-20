<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const INDEX_PATH_NAME = 'post_likes.index';
    public function index(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::withRelationOrderedBy('post_likes', 'created_at', 'DESC')->findOrFail($profileExploded[0]);
        $currentUser = request()->user();

        // If profile is not current users then forbidden
        if (!($currentUser && ($currentUser->id === $userObserved->id))) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        return [
            'post_likes' => $userObserved->post_likes,
            'time' => microtime(true) - LARAVEL_START,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'post_likes.store';
    public function store()
    {
        $user = request()->user();
        $postId = request()->post_id;
        $post = Post::with('author')->findOrFail($postId);

        if (is_null($user) || ($post->author->id === $user->id)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $postLike = $user->post_likes()->where('post_id', $postId)->first();

        if (is_null($postLike)) {
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
        }

        return Response::HTTP_OK;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    const DESTROY_PATH_NAME = 'post_likes.destroy';
    public function destroy()
    {
        $user = request()->user();
        $postId = request()->post_id;

        if (is_null($user)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $postLike = $user->post_likes()->where('post_id', $postId)->first();

        if ($postLike !== null) {
            $postLike->delete();
        }

        return Response::HTTP_OK;
    }
}
