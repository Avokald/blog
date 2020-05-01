<?php

namespace Tests\Feature;

use App\Models\Category;
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

}
