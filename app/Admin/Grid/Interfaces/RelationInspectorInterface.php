<?php


namespace App\Admin\Grid\Interfaces;


interface RelationInspectorInterface
{

    /**
     * @return InspectorInterface
     */
    public function getOwnerInspector();

    /**
     * @return string
     */
    public function getOwnerKey();

    /**
     * @return InspectorInterface
     */
    public function getForeignInspector();


    /**
     * @return string
     */
    public function getForeignKey();


    /**
     * @return int|string enum(
     *     RelationAttribute::RELATION_HAS_ONE,
     *     RelationAttribute::RELATION_BELONG_TO,
     *     RelationAttribute::RELATION_HAS_MANY
     * )
     */
    public function getRelationshipType();
}