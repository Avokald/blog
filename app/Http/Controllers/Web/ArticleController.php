<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const INDEX_PATH_NAME = 'article.index';

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    const SHOW_PATH_NAME = 'articles.show';

    public function show(string $articlePath)
    {
        $articlePathExploded = explode('-', $articlePath, 2);
        $article = Article::findOrFail($articlePathExploded[0]);
        $userObserver = request()->user();
//        echo $article . ' | ';

        // If the status is not published and the current user is not the author
        // then return 404
        if (($article->status !== Article::STATUS_PUBLISHED)
            && !($userObserver && ($userObserver->id === $article->user_id))) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        // Redirect if slug is not provided or incorrect
        // Must be run later so there would be no redirect when model is private
        if (!isset($articlePathExploded[1], $article->slug) || ($articlePathExploded[1] !== $article->slug)) {
            return redirect($article->getShowLink());
        }

        return [
            'article' => $article,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
