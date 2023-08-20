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
            $table->integer('user_id')->default(0);
            $table->string('title', 255)->default('');
            $table->integer('category_id')->default(0);
            $table->integer('topic_id')->default(0);
            $table->string('from_account', 255);
            $table->text('summary');
            $table->text('full_message');
            $table->string('image', 255)->default('');
            $table->string('file_attach', 255)->default('');
            $table->string('post_state', 255)->default('');
            $table->boolean('approved')->default('0');
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
