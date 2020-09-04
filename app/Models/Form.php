<?php

namespace App\Models;

use App\Admin\Facades\Admin;
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


    public function toForm(){

        $children = [];
        /** @var FormInput $input */
        foreach ($this->inputs as $input){
            $properties = array_merge([
                'name' => $input->name,
                'label' => $input->label,
            ], $input->properties);

            $children[] = Admin::createElement($input->type, $properties);
        }

        return Admin::createElement("form", [
            'children' => $children
        ]);
    }


    public function toFormSection(){
        $children = [];
        /** @var FormInput $input */
        foreach ($this->inputs as $input){
            $properties = array_merge([
                'name' => $input->name,
                'label' => $input->label,
            ], $input->properties);

            $children[] = Admin::createElement($input->type, $properties);
        }

        return Admin::createElement("form-section", [
            'children' => $children
        ]);
    }
}
