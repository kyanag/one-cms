<?php


namespace App\Admin\Grid\Interfaces;


interface GridColumnInterface
{


    public function __invoke($model, $key, $index);


    public function getLabel();


    public function getName();

}