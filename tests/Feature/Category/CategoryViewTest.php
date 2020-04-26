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

    public function testCategoryPageDisplaysInformation()
    {
        $category = factory(Category::class)->create();

        $postsData = [
            'titles' => [],
            'created_ats' => [],
        ];
        for ($i = 0; $i < 10; $i++) {
            $post = factory(Post::class)->create([
                'category_id' => $category->id,
            ]);
            $postsData['titles'][] = $post->title;
            $postsData['created_ats'][] = $post->created_at;
        }

        $response = $this->get($category->getShowlink());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText($category->title);
        $response->assertSeeText($category->description);

        $response->assertSeeTextInOrder($postsData['titles']);
        $response->assertSeeTextInOrder($postsData['created_ats']);
    }
}
