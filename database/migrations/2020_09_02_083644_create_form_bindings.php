<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormBindings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_bindings', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger("site_id")->default(0)->comment("站点id");
            $table->string("entity_type")->comment("实体类型");
            $table->integer("entity_id")->comment("实体id");
            $table->integer("form_id")->comment("表单id");
            $table->boolean("is_collection")->default(false)->comment("是否绑定为集合");
            $table->tinyInteger("status")->default(0)->comment("-1删除 0正常 1停用");
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
        Schema::dropIfExists('form_bindings');
    }
}
