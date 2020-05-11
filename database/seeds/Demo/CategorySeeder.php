<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'title' => 'mycat',
            'description' => 'mydesc',
        ]);

        factory(Category::class, 5)
            ->create()
            ->each(function ($category) {
                $category->posts()->createMany(
                    factory(\App\Models\Post::class, 10)->make([
                        'category_id' => $category->id,
                    ])->toArray()
                );
            });
    }
}
