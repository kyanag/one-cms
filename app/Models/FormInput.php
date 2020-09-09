<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormInput extends Model
{
    //
    protected $guarded = [];


    public function form(){
        return $this->belongsTo(Form::class, "id", "form_id");
    }


    public function getPropertiesAttribute(){
        return json_decode(@$this->attributes['properties'] ?: "[]", true);
    }
}
