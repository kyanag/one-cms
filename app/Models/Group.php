<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $guarded = [];


    public function scopeForConfig($query){
        return $query->where("type", 1);
    }


    public function configs(){
        return $this->hasMany(Config::class, "group_id", "id");
    }
}
