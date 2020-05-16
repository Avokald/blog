<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('content');

            $table->bigInteger('user_id');
            $table->bigInteger('post_id');
            $table->bigInteger('reply_id')->nullable();
            $table->bigInteger('parent_1_id')->nullable();
            $table->bigInteger('parent_2_id')->nullable();
            $table->bigInteger('parent_3_id')->nullable();

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
        Schema::dropIfExists('comments');
    }
}
