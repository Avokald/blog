<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostListTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function testPostsNewIsSortedInOrderByCreationTime()
    {
        $this->seed(\PostSeeder::class);

        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        for ($i = 4; $i > 0; $i--) {
            $art = factory(Post::class)->create([
                'created_at' => time() + ($i * 10),
            ]);
            $postsData['titles'][] = $art->title;
            $postsData['contents'][] = $art->content;
            $postsData['created_ats'][] = $art->created_at;
        }

        $response = $this->get(route(PostController::NEW_PATH_NAME));

        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopIsSortedInOrderByScore()
    {
        $this->seed(\PostSeeder::class);

        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME));

        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopByDayInOrderByScoreAndDoesNotContainPreviousPosts()
    {
        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedPostsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subHours(25)->unix(),
            ]);

            $notAllowedPostsData['titles'][] = $post->title;
            $notAllowedPostsData['contents'][] = $post->content;
            $notAllowedPostsData['created_ats'][] = $post->created_at;
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subHours(23)->unix(),
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, 'day'));

        // Posts that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedPostsData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedPostsData['titles'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['contents'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['created_ats'][$i]);
        }

        // Posts before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopByWeekInOrderByScoreAndDoesNotContainPreviousPosts()
    {
        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedPostsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(8)->unix(),
            ]);

            $notAllowedPostsData['titles'][] = $post->title;
            $notAllowedPostsData['contents'][] = $post->content;
            $notAllowedPostsData['created_ats'][] = $post->created_at;
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(6)->unix(),
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_WEEK_STRING));

        // Posts that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedPostsData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedPostsData['titles'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['contents'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['created_ats'][$i]);
        }

        // Posts before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopByMonthInOrderByScoreAndDoesNotContainPreviousPosts()
    {
        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedPostsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(32)->unix(),
            ]);

            $notAllowedPostsData['titles'][] = $post->title;
            $notAllowedPostsData['contents'][] = $post->content;
            $notAllowedPostsData['created_ats'][] = $post->created_at;
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(29)->unix(),
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_MONTH_STRING));

        // Posts that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedPostsData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedPostsData['titles'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['contents'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['created_ats'][$i]);
        }

        // Posts before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopByYearInOrderByScoreAndDoesNotContainPreviousPosts()
    {
        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        $notAllowedPostsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(366)->unix(),
            ]);

            $notAllowedPostsData['titles'][] = $post->title;
            $notAllowedPostsData['contents'][] = $post->content;
            $notAllowedPostsData['created_ats'][] = $post->created_at;
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(364)->unix(),
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_YEAR_STRING));

        // Posts that are beyond the limit should not be displayed
        for ($i = 0; $i < count($notAllowedPostsData['titles']); $i++) {
            $response->assertDontSeeText($notAllowedPostsData['titles'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['contents'][$i]);
            $response->assertDontSeeText($notAllowedPostsData['created_ats'][$i]);
        }

        // Posts before the limit should be displayed in order of score
        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }

    public function testPostsTopByAllTimeInOrderByScoreAndContainsAllPosts()
    {
        $postsData = [
            'titles' => [],
            'contents' => [],
            'created_ats' => [],
        ];

        // Posts from 2 years ago with high rating
        for ($i = 10; $i > 1; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(700)->unix(),
            ]);

            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        // Current posts with low rating
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['contents'][] = $post->content;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_ALL_TIME_STRING));

        // All posts should be displayed in order of score
        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['contents']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }
}
