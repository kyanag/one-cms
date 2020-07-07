<?php


namespace App\Admin\Grid\Columns;


class CheckboxColumn extends DataColumn
{

    /**
     * 多选框的输入框名称
     * @var string
     */
    public $inputName = "selection";


    public function boot()
    {
        if (substr_compare($this->inputName, '[]', -2, 2)) {
            $this->inputName .= '[]';
        }
        $this->content = function($model, $key, $index){
            return "<label><input type=\"checkbox\" name=\"{$this->inputName}\" value='{$model[$this->getName()]}'></label>";
        };
        return parent::boot();
    }

}