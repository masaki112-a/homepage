<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostUserTagsTable extends Migration
{
    public function up()
    {
        Schema::create('post_user_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('tag'); // 'favorite' or 'read_later'
            $table->timestamps();
            $table->unique(['user_id', 'post_id', 'tag']); // ユニーク制約
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_user_tags');
    }
}