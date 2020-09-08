<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use CanBindFormTrait;
    //

    protected $guarded = [
        "form_bindings"
    ];


    protected static function boot()
    {
        parent::boot();
        static::saving(function(Category $model){
            if($model->isDirty("parent_id")){
                //判断栏目的上级栏目是否合法
            }
        });

        static::addGlobalScope("store", function($query){
            return $query->where("store_id", app("env.store")['id']);
        });
    }


    public function getLabels(){
        return [
            'title' => "栏目名称",
            'keywords' => "关键词",
            'description' => "简介",
            'parent_id' => "上级栏目",
            'type' => "类型",
            'url' => "地址",
            'status' => "状态",
            'created_at' => "创建时间",
            'updated_at' => "修改时间",
        ];
    }
}
