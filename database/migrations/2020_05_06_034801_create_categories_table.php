<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger("site_id")->comment("站点id");
            $table->string("title", 20)->nullable()->comment("栏目名称");
            $table->string("bg_img")->nullable()->comment("背景图片");
            $table->string("keywords", 100)->nullable()->comment("SEO 关键字");
            $table->string("description")->nullable()->comment("SEO 描述");
            $table->unsignedInteger("parent_id")->default(0)->comment("上级栏目");
            $table->string("type", 50)->comment("栏目类型");
            $table->string("url")->nullable()->comment("栏目跳转");
            $table->tinyInteger("status")->comment("栏目状态 0不显示 1显示");
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
        Schema::dropIfExists('categories');
    }
}
