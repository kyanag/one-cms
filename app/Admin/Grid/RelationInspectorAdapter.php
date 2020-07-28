<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\RelationAttribute;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;

class RelationInspectorAdapter implements RelationInspectorInterface
{
    /**
     * @var InspectorInterface
     */
    protected $ownInspector;

    /**
     * @var InspectorInterface
     */
    protected $foreignInspector;

    /**
     * @var RelationAttribute
     */
    protected $relationAttribute;

    public function __construct(
        RelationAttribute $relationAttribute,
        InspectorInterface $ownInspector,
        InspectorInterface $foreignInspector
    )
    {
        $this->relationAttribute = $relationAttribute;
        $this->ownInspector = $ownInspector;
        $this->foreignInspector = $foreignInspector;

    }


    public function getOwnerInspector(){
        return $this->ownInspector;
    }

    public function getOwnerKey(){
        return $this->relationAttribute->ownerKey;
    }


    public function getForeignInspector(){
        return $this->foreignInspector;
    }


    public function getForeignKey(){
        return $this->relationAttribute->foreignKey;
    }

    /**
     * @return string enum(
     *     RelationAttribute::RELATION_HAS_ONE,
     *     RelationAttribute::RELATION_BELONG_TO,
     *     RelationAttribute::RELATION_HAS_MANY
     * )
     */
    public function getRelationshipType(){
        return $this->relationAttribute->type;
    }
}