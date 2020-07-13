<?php


namespace App\Admin\Grid\Interfaces;


interface ModelInspectorInterface
{

    /**
     * @return string
     */
    public function getTitle();


    /**
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getModelClass();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return array<AttributeInspectorInterface>
     */
    public function getAttributes();

}