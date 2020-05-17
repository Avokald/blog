<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'comments.store';
    public function store(string $postId)
    {
        $post = Post::findOrFail($postId);

        $user = request()->user();

        if ($user === null) {
            return abort(ResponseCode::HTTP_FORBIDDEN);
        }

        $data = request()->get('data');
        $comment = Comment::create([
            'content' => $data['content'],
            'user_id' => $user->id,
            'post_id' => $post->id,
            'reply_id' => $data['reply_id'] ?? null,
        ]);

        return response()
            ->json([])
            ->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    /*
    const LOAD_RESPONSES_PATH_NAME = 'comments.load_responses';
    public function loadResponses(string $commentId)
    {
        $comment = DB::select("
        select id,
        content,
        user_id,
        post_id,
        reply_id
        from    (select * from comments
                 order by reply_id, id) products_sorted,
                (select @pv := ?) initialisation
        where   find_in_set(reply_id, @pv)
        and     length(@pv := concat(@pv, ',', id))
        ", [$commentId]);

        $com = new Comment();
        $com->fill([
            'id' => $comment[0]->id,
            'content' => $comment[0]->content,
            'user_id' => $comment[0]->user_id,
            'post_id' => $comment[0]->post_id,
            'reply_id' => $comment[0]->reply_id,
        ]);
        dd($com->author);
        $comment = Comment::findOrFail($commentId);

        $comments = [];

        $parent = $comment->repliedTo;
        while ($parent->id) {
            $comments[] = $parent;
            $parent = $parent->repliedTo;
        }


        $allReplies = [];

        $replies = $comment->replies;
        foreach ($replies as $reply) {

        }

        return $comments;
    }
    */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
