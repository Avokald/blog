<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->json('json_content')->nullable();

            $table->unsignedSmallInteger('status')->default(Article::STATUS_DRAFT);
            $table->bigInteger('rating')->default(0);

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
        Schema::dropIfExists('articles');
    }
}
