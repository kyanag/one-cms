<?php


namespace App\Admin\Grid\Interfaces;


interface InspectorInterface
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
     * @return array<FieldInspectorInterface>
     */
    public function getFields();


    /**
     * @return array<RelationInspectorInterface>
     */
    public function getRelations();

    /**
     * @param $name
     * @return RelationInspectorInterface
     */
    public function getRelation($name);
}