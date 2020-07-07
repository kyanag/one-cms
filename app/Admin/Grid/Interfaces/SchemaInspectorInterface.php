<?php


namespace App\Admin\Grid\Interfaces;


interface SchemaInspectorInterface
{

    /**
     * @return string
     */
    public function title();


    /**
     * return classname
     * @return string
     */
    public function modelClass();


    /**
     * @return array<FieldInspectorInterface>
     */
    public function fields();
}