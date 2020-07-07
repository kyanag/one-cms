<?php


namespace App\Admin\Grid\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface FieldInspectorInterface
{

    /**
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getLabel();


    /**
     * @return mixed
     */
    public function getOriginAttributes();


    /**
     * @return SchemaInspectorInterface
     */
    public function getSchema();
}