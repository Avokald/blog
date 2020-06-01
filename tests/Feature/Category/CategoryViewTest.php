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

        $postsData = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        $notDisplayedData = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 5; $i > 0; $i--) {
            $post = factory(Post::class)->make([
                'category_id' => $category->id,
            ]);
            $post->created_at = time() + ($i * 10);
            $post->save();

            $this->saveCommonData($postsData, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        for ($i = 10; $i > 5; $i--) {
            $post = factory(Post::class)->make([
                'status' => Post::STATUS_DRAFT,
                'category_id' => $category->id,
            ]);
            $post->created_at = time() + ($i * 100);
            $post->save();

            $this->saveCommonData($notDisplayedData, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        $response = $this->get($category->link);

        $this->assertSeeTextInOrderForCommonData($response, $postsData, PostListTest::DATA_FIELDS_FOR_CHECK);

        $this->assertDontSeeTextInOrderForCommonData($response, $notDisplayedData,PostListTest::DATA_FIELDS_FOR_CHECK);
    }
}
