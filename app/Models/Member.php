<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $guarded = [];

    protected $fillable = [
        ''
    ];

    public function getTitleAttribute(){
        return $this->name;
    }

    protected static function boot()
    {
        static::addGlobalScope("store", function($query){
            return $query->where("store_id", app("admin.site")['id']);
        });

        static::addGlobalScope("deleted", function($query){
            return $query->whereNull("deleted_at");
        });
    }
}
