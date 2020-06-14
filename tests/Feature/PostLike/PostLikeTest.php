<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostLikeController;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_postLikes_page_is_displayed_only_for_author_user()
    {
        $user = factory(User::class)->create();
        $userGuest = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }


        // Author of the post like
        $response = $this
            ->actingAs($user)
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_OK);


        // Guest user
        $response = $this
            ->actingAs($userGuest)
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);


        // Not registered user
        $response = $this
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_likes_ordered_by_creation_date_desc()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            $postLike = PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $postLike->created_at = Carbon::now()->subDays($i);
            $postLike->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }


        $response = $this
            ->actingAs($user)
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_can_be_liked()
    {
        $this->seed(\UserSeeder::class);

        $post = factory(Post::class)->create();
        $user = factory(User::class)->create();

        // Add post to user likes
        $response = $this->actingAs($user)
            ->postJson(route(PostLikeController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

//        $this->print_r($response->getContent());
        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user liked posts page
        $response = $this->actingAs($user)
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_cant_be_liked_as_anonymous()
    {
        $post = factory(Post::class)->create();

        // Add post to user liked posts
        $response = $this->postJson(route(PostLikeController::STORE_PATH_NAME), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_post_can_be_removed_from_liked()
    {
        $post = factory(Post::class)->make();
        $post->created_at = time() - 10000;
        $post->save();

        $user = factory(User::class)->create();

        PostLike::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(PostLikeController::DESTROY_PATH_NAME), [
                '_method' => 'delete',
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user postLikes page
        $response = $this->actingAs($user)
            ->get(route(PostLikeController::INDEX_PATH_NAME, $user->slugged_id));

        $this->assertDontSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_cant_be_liked_by_author()
    {
        $this->seed(\UserSeeder::class);

        $user = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        // Add post to user likes
        $response = $this->actingAs($user)
            ->postJson(route(PostLikeController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
