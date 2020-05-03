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

    const DATA_FIELDS_FOR_CHECK = [
        'title',
        'description',
    ];

    public function test_category_page_displays_information()
    {
        $category = factory(Category::class)->create();


        $response = $this->get($category->link);


        $response->assertStatus(Response::HTTP_OK);

        $response->assertSeeText(addcslashes($category->link, '/'));
        $this->assertSeeTextForCommonDataFromModel($response, $category);
    }

    public function test_category_page_displays_only_published_posts()
    {
        $category = factory(Category::class)->create();

        $postCommonData = ['title', 'created_at'];

        $postsData = $this->initializeCommonData($postCommonData);

        $notDisplayedData = $this->initializeCommonData($postCommonData);

        for ($i = 5; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'category_id' => $category->id,
                'created_at' => time() + ($i * 10),
            ]);
            $this->saveCommonData($postsData, $post, $postCommonData);
        }

        for ($i = 10; $i > 5; $i--) {
            $post = factory(Post::class)->create([
                'status' => Post::STATUS_DRAFT,
                'category_id' => $category->id,
                'created_at' => time() + ($i * 100),
            ]);
            $this->saveCommonData($notDisplayedData, $post, $postCommonData);
        }

        $response = $this->get($category->link);

        $this->assertSeeTextInOrderForCommonData($response, $postsData, $postCommonData);

        $this->assertDontSeeTextInOrderForCommonData($response, $notDisplayedData,$postCommonData);
    }
}
