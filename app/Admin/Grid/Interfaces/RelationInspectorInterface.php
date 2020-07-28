<?php


namespace App\Admin\Grid\Interfaces;


interface RelationInspectorInterface
{

    public function getOwnerInspector();


    public function getOwnerKey();

    /**
     * @return array<InspectorInterface>
     */
    public function getForeignInspector();


    public function getForeignKey();


    public function getRelationshipType();
}