<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbuseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuse_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('status')->default(\App\Models\AbuseRequest::STATUS_SUBMITTED);
            $table->bigInteger('post_id');
            $table->bigInteger('comment_id')->nullable();
            $table->bigInteger('target_id')->nullable();
            $table->bigInteger('user_id');

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
        Schema::dropIfExists('abuse_requests');
    }
}
