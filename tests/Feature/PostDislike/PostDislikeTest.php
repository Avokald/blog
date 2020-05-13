<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostDislikeController;
use App\Models\Post;
use App\Models\PostDislike;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostDislikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_post_dislikes_page_is_displayed_only_for_author_user()
    {
        $user = factory(User::class)->create();
        $userGuest = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            PostDislike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }


        // Author of the post like
        $response = $this
            ->actingAs($user)
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_OK);


        // Guest user
        $response = $this
            ->actingAs($userGuest)
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);


        // Not registered user
        $response = $this
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_dislikes_ordered_by_creation_date_desc()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            $postDislike = PostDislike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $postDislike->created_at = Carbon::now()->subDays($i);
            $postDislike->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }


        $response = $this
            ->actingAs($user)
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_can_be_disliked()
    {
        $this->seed(\UserSeeder::class);

        $post = factory(Post::class)->create();
        $user = factory(User::class)->create();

        // Add post to user likes
        $response = $this->actingAs($user)
            ->postJson(route(PostDislikeController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

//        $this->print_r($response->getContent());
        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user liked posts page
        $response = $this->actingAs($user)
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_cant_be_disliked_as_unregistered_user()
    {
        $post = factory(Post::class)->create();

        // Add post to user liked posts
        $response = $this->postJson(route(PostDislikeController::STORE_PATH_NAME), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_post_can_be_removed_from_disliked()
    {
        $post = factory(Post::class)->create([
            'created_at' => time() - 10000,
        ]);
        $user = factory(User::class)->create();

        PostDislike::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(PostDislikeController::DESTROY_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user postDislikes page
        $response = $this->actingAs($user)
            ->get(route(PostDislikeController::INDEX_PATH_NAME, $user->slugged_id));

        $this->assertDontSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_cant_be_disliked_by_author()
    {
        $this->seed(\UserSeeder::class);

        $user = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        // Add post to user likes
        $response = $this->actingAs($user)
            ->postJson(route(PostDislikeController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
