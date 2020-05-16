<?php

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c1 = factory(Comment::class)->create([
            'content' => '1',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
        ]);
        $c1->created_at = time() - 1000;
        $c1->save();

        $c2 = factory(Comment::class)->create([
            'content' => '2',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c1->id,
            'parent_1_id' => $c1->id,
        ]);
        $c2->created_at = time() - 990;
        $c2->save();


        $c3 = factory(Comment::class)->create([
            'content' => '3',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c1->id,
            'parent_1_id' => $c1->id,
        ]);
        $c3->created_at = time() - 980;
        $c3->save();


        $c4 = factory(Comment::class)->create([
            'content' => '4',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c1->id,
            'parent_1_id' => $c1->id,
        ]);
        $c4->created_at = time() - 970;
        $c4->save();


        $c5 = factory(Comment::class)->create([
            'content' => '5',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c1->id,
            'parent_1_id' => $c1->id,
        ]);
        $c5->created_at = time() - 960;
        $c5->save();


        $c6 = factory(Comment::class)->create([
            'content' => '6',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c2->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
        ]);
        $c6->created_at = time() - 950;
        $c6->save();


        $c7 = factory(Comment::class)->create([
            'content' => '7',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c2->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
        ]);
        $c7->created_at = time() - 940;
        $c7->save();


        $c8 = factory(Comment::class)->create([
            'content' => '8',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c6->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
        ]);
        $c8->created_at = time() - 930;
        $c8->save();


        $c9 = factory(Comment::class)->create([
            'content' => '9',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c8->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
            'parent_3_id' => $c6->id,
        ]);
        $c9->created_at = time() - 920;
        $c9->save();


        $c10 = factory(Comment::class)->create([
            'content' => '10',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c6->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
            'parent_3_id' => $c6->id,
        ]);
        $c10->created_at = time() - 910;
        $c10->save();


        $c11 = factory(Comment::class)->create([
            'content' => '11',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c9->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
            'parent_3_id' => $c6->id,
        ]);
        $c11->created_at = time() - 900;
        $c11->save();


        $c12 = factory(Comment::class)->create([
            'content' => '12',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            'reply_id' => $c8->id,
            'parent_1_id' => $c1->id,
            'parent_2_id' => $c2->id,
            'parent_3_id' => $c6->id,
        ]);
        $c12->created_at = time() - 890;
        $c12->save();



        $c13 = factory(Comment::class)->create([
            'content' => '13',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
        ]);

        $c14 = factory(Comment::class)->create([
            'content' => 'test comment content 1',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
        ]);

        $c15 = factory(Comment::class)->create([
            'content' => 'test comment content 2',
            'user_id' => UserSeeder::TEST_USER_ID,
            'post_id' => PostSeeder::TEST_PUBLISHED_ID,
        ]);

        $posts = Post::published()->get();

        foreach ($posts as $post) {
            factory(Comment::class)->create([
                'content' => 'test comment content',
                'user_id' => UserSeeder::TEST_USER_ID,
                'post_id' => $post->id,
            ]);
        }
    }

}
