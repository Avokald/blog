<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'reports.store';
    public function store(Request $request)
    {
//        $report = Report::create([
//            'content_id' => $request['post_id'],
//        ]);
        $user = $request->user();

        if ($user === null) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $post = Post::findOrFail($request['post_id']);


        Report::create([
            'post_id' => $post->id,
            'comment_id' => $request['comment_id'] ?? null,
            'offender_id' => $request['user_id'] ?? null,
            'informer_id' => $user->id,
        ]);

        return response()
            ->json([])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }
}
