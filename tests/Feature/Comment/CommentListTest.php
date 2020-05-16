<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentListTest extends TestCase
{
    use RefreshDatabase;

    const DATA_FIELDS_FOR_CHECK = [
        'content',
    ];

    private $post = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);
    }

    public function test_post_comment_displays_information()
    {
        $comment = factory(Comment::class)->create([
            'post_id' => $this->post->id,
        ]);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $this->post->slugged_id));

        $response->assertSeeText($comment->content);
    }
}
