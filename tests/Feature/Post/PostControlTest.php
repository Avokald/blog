<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControlTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function test_post_can_be_created_by_user()
    {
        $this->seed(\PostSeeder::class);
        $this->seed(\UserSeeder::class);
        usleep(100);

        $user = factory(User::class)->create();
        $post = factory(Post::class)->make([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $response = $this->postJson(route(PostController::STORE_PATH_NAME), $post->toArray());

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this
            ->actingAs($user)
            ->postJson(route(PostController::STORE_PATH_NAME), $post->toArray());

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas($post->getTable(), [
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'content' => $post->content,
            'status' => $post->status,
        ]);

        $response = $this->get(route(PostController::NEW_PATH_NAME));

        $this->assertSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

}
