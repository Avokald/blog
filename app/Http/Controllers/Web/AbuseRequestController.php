<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AbuseRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbuseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const INDEX_PATH_NAME = 'abuse_requests.index';
    public function index()
    {
        $abuseRequests = AbuseRequest::with('post')->orderBy('created_at', 'desc')->limit(10)->get();
        return $abuseRequests;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'abuse_requests.store';
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user === null) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $post = Post::findOrFail($request['post_id']);
        $targetUser = $post->author;
        $commentId = null;

        if (isset($request['comment_id']) && $request['comment_id']) {
            $comment = Comment::findOrFail($request['comment_id']);
            $targetUser = $comment->author;
            $post = $comment->post;
            $commentId = $comment->id;
        }


        AbuseRequest::create([
            'post_id' => $post->id,
            'comment_id' => $commentId,
            'target_id' => $targetUser->id,
            'user_id' => $user->id,
        ]);

        return response()
            ->json([])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AbuseRequest  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AbuseRequest $report)
    {
        //
    }
}
