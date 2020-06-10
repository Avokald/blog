<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const INDEX_PATH_NAME = 'articles.index';
    public function index()
    {
        //
    }

    /**
     * Display a listing of the sorted by creation date.
     *
     * @return \Illuminate\Http\Response
     */
    const NEW_PATH_NAME = 'articles.new';

    public function newArticles()
    {
        $articles = Post::with('category')
            ->published()
            ->orderBy('created_at', 'desc')
            ->get();

        return $articles;
    }

    /**
     * Display a listing of sorted articles by rating
     *
     */
    const TOP_PATH_NAME = 'articles.top';
    const TOP_PATH_DAY_STRING = 'day';
    const TOP_PATH_WEEK_STRING = 'week';
    const TOP_PATH_MONTH_STRING = 'month';
    const TOP_PATH_YEAR_STRING = 'year';
    const TOP_PATH_ALL_TIME_STRING = 'all';

    public function topArticles(?string $timeframe = null)
    {
        if (is_null($timeframe)
            || ($timeframe === self::TOP_PATH_DAY_STRING)) {
            $timeframeScope = 'last24Hours';

        } else if ($timeframe === self::TOP_PATH_WEEK_STRING) {
            $timeframeScope = 'last7Days';

        } else if ($timeframe === self::TOP_PATH_MONTH_STRING) {
            $timeframeScope = 'last30Days';

        }  else if ($timeframe === self::TOP_PATH_YEAR_STRING) {
            $timeframeScope = 'last365Days';

        } else if ($timeframe === self::TOP_PATH_ALL_TIME_STRING) {
            $timeframeScope = 'noScope';

        } else {
            return redirect(route($this::TOP_PATH_NAME));

        }

        $articles = Post::with('category')
            ->published()
            ->$timeframeScope()
            ->orderBy('rating', 'desc')
            ->get();

        return $articles;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'posts.store';
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user === null) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'max:255',
            'content' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->get('title'),
            'excerpt' => $request->get('excerpt'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'user_id' => $user->id,
            'category_id' => $request->get('category_id'),
            'tags' => $request->get('tags'),
        ]);

        return response()->json([])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $article
     * @return \Illuminate\Http\Response
     */
    const SHOW_PATH_NAME = 'articles.show';
    public function show(string $articlePath)
    {
        $articlePathExploded = explode('-', $articlePath, 2);

        $article = Post::with('category')
            ->withRelationOrderedBy('comments', 'created_at', 'DESC')
            ->findOrFail($articlePathExploded[0]);
//        $article = DB::select("
//        SELECT post.*,
//        category.title as category_title, category.slug as category_slug, category.image as category_image,
//        post_author.id as author_id, post_author.name as author_name, post_author.slug as author_slug, post_author.image as author_image
//        FROM posts as post
//        INNER JOIN categories as category
//        ON post.category_id = category.id
//        INNER JOIN users as post_author
//        ON post.user_id = post_author.id
//        WHERE post.id = ?
//        ", [$articlePathExploded[0]])[0];

        $userObserver = request()->user();

        // If the status is not published and the current user is not the author
        // then return 404
        if (($article->status !== Post::STATUS_PUBLISHED)
            && !($userObserver && ($userObserver->id === $article->user_id))) {
            return abort(Response::HTTP_NOT_FOUND);
        }

//        DB::update("UPDATE posts SET view_count = view_count + 1 WHERE id = ?", [$article->id]);
        $article->view_count += 1;
        $article->save();

//        return json_decode(json_encode($article), true);
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Post $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $article)
    {
        //
    }
}
