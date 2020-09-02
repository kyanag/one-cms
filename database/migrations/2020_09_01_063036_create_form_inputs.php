<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormInputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("form_id")->comment("所属form集合");
            $table->string("name")->comment("字段名称");
            $table->string("label")->comment("字段标题");
            $table->string("type")->comment("表单类型");
            $table->tinyInteger("index")->default(0)->comment("排序");
            $table->json("properties")->nullable()->comment("表单配置");
            $table->tinyInteger("status")->default(0)->comment("0正常，-1删除 1隐藏");
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
        Schema::dropIfExists('form_inputs');
    }
}
