<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{


    protected $guarded = [
        "inputs"
    ];

    public function inputs(){
        return $this->hasMany(FormInput::class, "form_id", "id");
    }

    public function getLabels(){
        return [
            'name' => "表单名称",
            'title' => "表单标题",
            'group_id' => "分类",
            'desc' => "简介",
            'status' => "状态",
        ];
    }
}
