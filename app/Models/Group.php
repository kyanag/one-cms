<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //系统配置类型 configs
    const TYPE_FOR_CONFIG = 1;
    //管理员类型
    const TYPE_FOR_USER_GROUP = 10;

    //表单类型-文章
    const TYPE_FOR_FORM_ARTICLE = 20;
    //表单类型-栏目
    const TYPE_FOR_FORM_CATEGORY = 21;
    //表单类型-问卷
    const TYPE_FOR_FORM_PAPER = 22;


    const TYPE_FOR_OTHER = 9999;


    protected $guarded = [];


    public function scopeForConfig($query){
        return $query->where("type", static::TYPE_FOR_CONFIG);
    }

    public function scopeFor($query, $type){
        return $query->where("type", $type);
    }


    public function configs(){
        return $this->hasMany(Config::class, "group_id", "id");
    }
}
