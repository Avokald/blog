<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\PostController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private $test_post = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_post = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);
    }

    public function test_post_can_be_commented()
    {
        $user = factory(User::class)->create();
        $commentData = [
            'content' => 'Test content',
        ];

        $response = $this->actingAs($user)
            ->postJson(route(CommentController::STORE_PATH_NAME, $this->test_post->id), [
                'data' => $commentData,
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $this->test_post->slugged_id));

        $response->assertSeeText($commentData['content']);
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->link);
    }

    public function test_comment_can_be_replied()
    {
        $user = factory(User::class)->create();
        $parentUser = factory(User::class)->create();
        $commentParent = factory(Comment::class)->create([
            'user_id' => $parentUser->id,
        ]);

        $commentData = [
            'content' => 'Test content',
            'reply_id' => $commentParent->id,
        ];

        $response = $this->actingAs($user)
            ->postJson(route(CommentController::STORE_PATH_NAME, $this->test_post->id), [
                'data' => $commentData,
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $this->test_post->slugged_id));

        $response->assertSeeText($commentParent->content);
        $response->assertSeeText($commentData['content']);
        $response->assertSeeText($commentParent->author->name);
        $response->assertSeeText($user->name);
//        $response->assertSeeTextInOrder([$commentParent->content, $commentData['content']]);
//        $response->assertSeeTextInOrder([$commentParent->author->name, $user->name]);
    }


    /*
    public function test_comment_responses_can_be_loaded()
    {
        $user = factory(User::class)->create();

        $commentParent1 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
        ]);
        $commentParent2 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent1->id,
        ]);
        $commentParent3 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent2->id,
        ]);

        $commentParent4 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent3->id,
        ]);

        $commentParent5 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent3->id,
        ]);

        $commentParent6 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent3->id,
        ]);

        $commentParent7 = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $this->test_post->id,
            'reply_id' => $commentParent3->id,
        ]);

        $response = $this->get(route(CommentController::LOAD_RESPONSES_PATH_NAME, $commentParent3->id));

        $response->assertSeeTextInOrder([
            $commentParent4->content,
            $commentParent5->content,
            $commentParent6->content,
            $commentParent7->content,
        ]);

    }
    */
}
