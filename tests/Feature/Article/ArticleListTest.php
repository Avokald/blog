<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\ArticleController;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleListTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function testArticlesNewIsSortedInOrderByCreationTime()
    {
        $this->seed(\ArticleSeeder::class);

        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        for ($i = 4; $i > 0; $i--) {
            $art = factory(Article::class)->create([
                'created_at' => time() + ($i * 10),
            ]);
            $articlesData['titles'][] = $art->title;
            $articlesData['contents'][] = $art->content;
            $articlesData['created_ats'][] = $art->created_at;
        }

        $response = $this->get(route(ArticleController::NEW_PATH_NAME));

        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopIsSortedInOrderByScore()
    {
        $this->seed(\ArticleSeeder::class);

        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME));

        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopByDayInOrderByScoreAndDoesNotContainPreviousArticles()
    {
        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedArticlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Articles beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subHours(25)->unix(),
            ]);

            $notAllowedArticlesData['titles'][] = $article->title;
            $notAllowedArticlesData['contents'][] = $article->content;
            $notAllowedArticlesData['created_ats'][] = $article->created_at;
        }

        // Articles before the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subHours(23)->unix(),
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME, 'day'));

        // Articles that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedArticlesData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedArticlesData['titles'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['contents'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['created_ats'][$i]);
        }

        // Articles before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopByWeekInOrderByScoreAndDoesNotContainPreviousArticles()
    {
        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedArticlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Articles beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(8)->unix(),
            ]);

            $notAllowedArticlesData['titles'][] = $article->title;
            $notAllowedArticlesData['contents'][] = $article->content;
            $notAllowedArticlesData['created_ats'][] = $article->created_at;
        }

        // Articles before the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(6)->unix(),
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME, ArticleController::TOP_PATH_WEEK_STRING));

        // Articles that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedArticlesData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedArticlesData['titles'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['contents'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['created_ats'][$i]);
        }

        // Articles before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopByMonthInOrderByScoreAndDoesNotContainPreviousArticles()
    {
        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedArticlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Articles beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(32)->unix(),
            ]);

            $notAllowedArticlesData['titles'][] = $article->title;
            $notAllowedArticlesData['contents'][] = $article->content;
            $notAllowedArticlesData['created_ats'][] = $article->created_at;
        }

        // Articles before the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(29)->unix(),
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME, ArticleController::TOP_PATH_MONTH_STRING));

        // Articles that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedArticlesData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedArticlesData['titles'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['contents'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['created_ats'][$i]);
        }

        // Articles before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopByYearInOrderByScoreAndDoesNotContainPreviousArticles()
    {
        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedArticlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Articles beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(366)->unix(),
            ]);

            $notAllowedArticlesData['titles'][] = $article->title;
            $notAllowedArticlesData['contents'][] = $article->content;
            $notAllowedArticlesData['created_ats'][] = $article->created_at;
        }

        // Articles before the limit
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(364)->unix(),
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME, ArticleController::TOP_PATH_YEAR_STRING));

        // Articles that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedArticlesData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedArticlesData['titles'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['contents'][$i]);
            $response->assertDontSeeText($notAllowedArticlesData['created_ats'][$i]);
        }

        // Articles before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }

    public function testArticlesTopByAllTimeInOrderByScoreAndContainsAllArticles()
    {
        $articlesData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Articles from 2 years ago with high rating
        for ($i = 10; $i > 1; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(700)->unix(),
            ]);

            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        // Current articles with low rating
        for ($i = 10; $i > 0; $i--) {
            $article = factory(Article::class)->create([
                'rating' => $i * 10,
            ]);
            $articlesData['titles'][] = $article->title;
            $articlesData['contents'][] = $article->content;
            $articlesData['created_ats'][] = $article->created_at;
        }

        $response = $this->get(route(ArticleController::TOP_PATH_NAME, ArticleController::TOP_PATH_ALL_TIME_STRING));

        // All articles should be displayed in order of score
        $response->assertSeeTextInOrder($articlesData['titles']);
        $response->assertSeeTextInOrder($articlesData['contents']);
        $response->assertSeeTextInOrder($articlesData['created_ats']);
    }
}
