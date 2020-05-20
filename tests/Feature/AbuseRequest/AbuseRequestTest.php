<?php

namespace Tests\Feature;


use App\Http\Controllers\Web\AbuseRequestController;
use App\Models\AbuseRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AbuseRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_abuse_request_can_be_submitted()
    {
        $this->seed(\UserSeeder::class);
        $user = factory(User::class)->create();
        $postAuthor = factory(User::class)->create();
        $commentAuthor = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'title' => 'Illegal title',
            'content' => 'Illegal content',
            'user_id' => $postAuthor->id,
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'comment content',
            'user_id' => $commentAuthor->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(AbuseRequestController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('abuse_requests', [
            'post_id' => $post->id,
            'comment_id' => null,
            'target_id' => $postAuthor->id,
            'status' => AbuseRequest::STATUS_SUBMITTED,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(AbuseRequestController::STORE_PATH_NAME), [
                'post_id' => $post->id,
                'comment_id' => $comment->id,
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('abuse_requests', [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
            'target_id' => $commentAuthor->id,
            'status' => AbuseRequest::STATUS_SUBMITTED,
            'user_id' => $user->id,
        ]);
    }

    public function test_abuse_request_is_denied_if_unregistered_user()
    {
        $this->seed(\UserSeeder::class);
        $postAuthor = factory(User::class)->create();
        $commentAuthor = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'title' => 'Illegal title',
            'content' => 'Illegal content',
            'user_id' => $postAuthor->id,
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'comment content',
            'user_id' => $commentAuthor->id,
            'post_id' => $post->id,
        ]);

        $response = $this->postJson(route(AbuseRequestController::STORE_PATH_NAME), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);


        $response = $this->postJson(route(AbuseRequestController::STORE_PATH_NAME), [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

}
