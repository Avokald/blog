<?php

namespace Tests\Feature;


use App\Http\Controllers\Web\AbuseRequestController;
use App\Models\AbuseRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbuseRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_report_can_be_submitted()
    {
        $this->seed(\UserSeeder::class);
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Illegal title',
            'content' => 'Illegal content',
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(AbuseRequestController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $this->assertDatabaseHas('abuse_requests', [
            'post_id' => $post->id,
            'status' => AbuseRequest::STATUS_SUBMITTED,
            'user_id' => $user->id,
        ]);
    }
}
