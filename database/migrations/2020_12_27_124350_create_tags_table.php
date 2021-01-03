<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Name of tag, eg Football, Fishing, Computing
            $table->timestamps();
        });

        // Creating a pivot table between Posts and Tags
        // Naming convention = singular words, alphabetical, separated by underscore
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->unique(['post_id', 'tag_id']);

            // Add FK relationships from post_id in post_tag to id in posts
            // When a post is deleted, so too are its related tags in the post_tag pivot table
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            // Add FK relationships from tag_id in post_tag to id in tags
            // When a post is deleted, so too are its related tags in the post_tag pivot table
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(['tags', 'post_tag']);
    }
}
