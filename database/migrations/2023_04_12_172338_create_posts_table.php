<?php

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
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->integer('user_id');
            $table->integer('categrory_id');
            $table->timestamps();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('posts');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('posts_id')->references('post_id')->on('posts');
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
