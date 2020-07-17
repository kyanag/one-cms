<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->comment("内容标题");
            $table->unsignedInteger("category_id")->comment("所属分类");
            $table->string("keywords")->nullable()->comment("关键字");
            $table->string("description")->nullable()->comment("简介");
            $table->string("author_id")->default(0)->comment("作者id");
            $table->string("image")->nullable()->comment("封面图");
            $table->string("rank")->default(0)->comment("排序");
            $table->string("jump")->nullable()->comment("跳转链接");
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
