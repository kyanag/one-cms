<?php


namespace App\Admin\Grid\Interfaces;


interface ObjectBuilderProvider
{

    public function create($name, $properties);

}