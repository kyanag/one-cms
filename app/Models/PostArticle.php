<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostArticle extends Model
{
    //


    public function post(){
        return $this->belongsTo(Post::class, "post_id", "id");
    }
}
