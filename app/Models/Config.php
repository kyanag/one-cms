<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $guarded = [];


    public function getLabels(){
        return [
            'title' => "名称",
            'name' => "调用名",
            'value' => "值",
            'help' => "帮助",
            'group_id' => "分组",
            'created_at' => "创建时间",
            'updated_at' => "修改时间",
        ];
    }


    public function group(){
        return $this->belongsTo(Group::class, "group_id", "id");
    }
}
