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

    /**
     * Fields that would be saved, asserted and validated for existence / nonexistence
     */
    const DATA_FIELDS_FOR_CHECK = [
        'title',
        'content',
        'created_at',
    ];

    /**
     * Creates array of data with specified field
     * @return array
     */
    private function initializeCommonData()
    {
        $list = [];
        foreach (self::DATA_FIELDS_FOR_CHECK as $field) {
            $list[$field] = [];
        }
        return $list;
    }

    /**
     * Saves data into array with pulling fields from the model
     * @param $list container for saved values of previous fields
     * @param $post model which contains specified fields
     */
    private function saveCommonData(&$list, $post)
    {
        foreach (self::DATA_FIELDS_FOR_CHECK as $field) {
            $list[$field][] = $post->$field;
        }
    }

    /**
     * Asserts that response contains values in order from given list for each specified field
     * @param $response
     * @param $list container for previously saved field values
     */
    private function assertSeeTextInOrderForCommonData($response, $list)
    {
        foreach (self::DATA_FIELDS_FOR_CHECK as $field) {
            $response->assertSeeTextInOrder($list[$field]);
        }
    }

    /**
     * Asserts that response does not contain values from given list
     * @param $response
     * @param $list container for previously saved field values
     */
    private function assertDontSeeTextInOrderForCommonData($response, $list)
    {
        for ($i = 0; $i < count($list[self::DATA_FIELDS_FOR_CHECK[0]]); $i++) {
            foreach (self::DATA_FIELDS_FOR_CHECK as $field) {
                $response->assertDontSeeText($list[$field][$i]);
            }
        }
    }


    public function test_posts_new_is_sorted_in_order_by_creation_time()
    {
        $this->seed(\PostSeeder::class);

        $postsData = $this->initializeCommonData();

        for ($i = 4; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'created_at' => time() + ($i * 10),
            ]);

            $this->saveCommonData($postsData, $post);
        }

        $response = $this->get(route(PostController::NEW_PATH_NAME));

        $this->assertSeeTextInOrderForCommonData($response, $postsData);
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

}
