<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('excerpt')->nullable(); // 350 max
            $table->text('content')->nullable();
            $table->json('json_content')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedSmallInteger('status')->default(Post::STATUS_DRAFT);

            $table->bigInteger('user_id');
            $table->bigInteger('category_id')->nullable();
            $table->json('tags')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
