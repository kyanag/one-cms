<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger("site_id")->default(0)->comment("站点id");
            $table->string("name")->comment("表单名称");
            $table->string("title")->comment("表单标题");
            $table->tinyInteger("group_id")->default(\App\Models\Group::TYPE_FOR_FORM_ARTICLE)->comment("表单种类");
            $table->string("desc")->nullable()->comment("说明");
            $table->tinyInteger("status")->default(0)->comment("状态");
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
        Schema::dropIfExists('forms');
    }
}
