<?php


namespace App\Admin\Grid;


class InspectorReader
{

    public function from($metaObject){
        $this->reflectionObject = new \ReflectionObject($metaObject);
        return $this;
    }




}