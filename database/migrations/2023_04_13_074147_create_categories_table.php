<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('slug');
            $table->string('category_name');
            $table->timestamps();
        });
        Schema::table('likes', function (Blueprint $table) {
            $table->foreign('category_id')->references('slug')->on('categories');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('category_id')->references('slug')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
