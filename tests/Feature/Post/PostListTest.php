<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostListTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    const DATA_FIELDS_FOR_CHECK = [
        'title',
        'excerpt',
    ];


    public function test_posts_new_is_sorted_in_order_by_creation_time()
    {
        $this->seed(\PostSeeder::class);

        $postsData = $this->initializeCommonData();

        for ($i = 4; $i > 0; $i--) {
            $post = factory(Post::class)->make();
            $post->created_at = time() + ($i * 10);
            $post->save();

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::NEW_PATH_NAME));

        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_has_user_data()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get(route(PostController::NEW_PATH_NAME));

        $response->assertSeeText($user->name);
        $response->assertSeeText($user->created_at);
    }

    /*
    $users = factory(User::class, $i * 2)->create();
    foreach ($users as $user) {
        PostLike::create([
            'user_id' => $user,
            'post_id' => $post->id,
        ]);
    }

    public function test_posts_top_is_sorted_in_order_by_score()
    {
        $this->seed(\PostSeeder::class);

        $postsData = $this->initializeCommonData();

        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME));

        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_top_by_day_in_order_by_score_and_does_not_contain_previous_posts()
    {
        $postsData = $this->initializeCommonData();

        $notAllowedPostsData = $this->initializeCommonData();

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subHours(25)->unix(),
            ]);

            $this->saveCommonData($notAllowedPostsData, $post);
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subHours(23)->unix(),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, 'day'));

        // Posts that are beyond the limit should not be displayed
        $this->assertDontSeeTextInOrderForCommonData($response, $notAllowedPostsData);

        // Posts before the limit should be displayed in order of score
        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_top_by_week_in_order_by_score_and_does_not_contain_previous_posts()
    {
        $postsData = $this->initializeCommonData();

        $notAllowedPostsData = $this->initializeCommonData();

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(8)->unix(),
            ]);

            $this->saveCommonData($notAllowedPostsData, $post);
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(6)->unix(),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_WEEK_STRING));

        // Posts that are beyond the limit should not be displayed
        $this->assertDontSeeTextInOrderForCommonData($response, $notAllowedPostsData);

        // Posts before the limit should be displayed in order of score
        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_top_by_month_in_order_by_score_and_does_not_contain_previous_posts()
    {
        $postsData = $this->initializeCommonData();

        $notAllowedPostsData = $this->initializeCommonData();

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(32)->unix(),
            ]);

            $this->saveCommonData($notAllowedPostsData, $post);
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(29)->unix(),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_MONTH_STRING));

        // Posts that are beyond the limit should not be displayed
        $this->assertDontSeeTextInOrderForCommonData($response, $notAllowedPostsData);

        // Posts before the limit should be displayed in order of score
        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_top_by_year_in_order_by_score_and_does_not_contain_previous_posts()
    {
        $postsData = $this->initializeCommonData();

        $notAllowedPostsData = $this->initializeCommonData();

        // Posts beyond the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(366)->unix(),
            ]);

            $this->saveCommonData($notAllowedPostsData, $post);
        }

        // Posts before the limit
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
                'created_at' => Carbon::now()->subDays(364)->unix(),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_YEAR_STRING));

        // Posts that are beyond the limit should not be displayed
        $this->assertDontSeeTextInOrderForCommonData($response, $notAllowedPostsData);

        // Posts before the limit should be displayed in order of score
        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }

    public function test_posts_top_by_all_tome_in_order_by_score_and_contains_all_posts()
    {
        $postsData = $this->initializeCommonData();

        // Posts from 2 years ago with high rating
        for ($i = 10; $i > 1; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 100,
                'created_at' => Carbon::now()->subDays(700)->unix(),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        // Current posts with low rating
        for ($i = 10; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'rating' => $i * 10,
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::TOP_PATH_NAME, PostController::TOP_PATH_ALL_TIME_STRING));

        // All posts should be displayed in order of score
        $this->assertSeeTextInOrderForCommonData($response, $postsData);
    }
    */

}
