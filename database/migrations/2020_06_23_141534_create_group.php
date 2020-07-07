<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->comment("分组标题");
            $table->string("icon", 20)->nullable()->comment("图标");
            $table->tinyInteger("type")->comment("分组类型");
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
        Schema::dropIfExists('groups');
    }
}
