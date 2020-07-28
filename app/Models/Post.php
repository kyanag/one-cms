<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //


    public function article(){
        return $this->hasOne(PostArticle::class, "post_id", "id");
    }
}
