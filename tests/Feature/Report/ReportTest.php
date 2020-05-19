<?php

namespace Tests\Feature;


use App\Http\Controllers\Web\ReportController;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
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
            ->postJson(route(ReportController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $this->assertDatabaseHas('reports', [
            'post_id' => $post->id,
            'informer_id' => $user->id,
            'status' => Report::STATUS_SUBMITTED,
        ]);
    }
}
