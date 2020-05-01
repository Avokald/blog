<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_page_displays_information()
    {
        $category = factory(Category::class)->create();

        $response = $this->get($category->link);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText($category->title);
        $response->assertSeeText($category->description);
        $response->assertSeeText(addcslashes($category->link, '/'));
    }

    public function test_category_page_displays_only_published_posts()
    {
        $category = factory(Category::class)->create();

        $postsData = [
            'titles' => [],
            'created_ats' => [],
        ];

        $notDisplayedData = [
            'titles' => [],
            'created_ats' => [],
        ];

        for ($i = 5; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'category_id' => $category->id,
                'created_at' => time() + ($i * 10),
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['created_ats'][] = $post->created_at;
        }

        for ($i = 10; $i > 5; $i--) {
            $post = factory(Post::class)->create([
                'status' => Post::STATUS_DRAFT,
                'category_id' => $category->id,
                'created_at' => time() + ($i * 100),
            ]);
            $notDisplayedData['titles'][] = $post->title;
            $notDisplayedData['created_ats'][] = $post->created_at;
        }

        $response = $this->get($category->link);

        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['created_ats']);

        for ($i = 0; $i < count($notDisplayedData['titles']); $i++) {
            $response->assertDontSeeText($notDisplayedData['titles'][$i]);
            $response->assertDontSeeText($notDisplayedData['created_ats'][$i]);
        }
    }
}
