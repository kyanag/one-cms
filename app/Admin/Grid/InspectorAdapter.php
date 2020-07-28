<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;

class InspectorAdapter implements InspectorInterface
{

    /**
     * @var SchemaAttribute
     */
    private $schemaAttribute;

    /**
     * @var array<AttributeInspectorInterface>
     */
    private $attributeInspectors = [];

    /**
     * @var array<RelationInspectorInterface>
     */
    private $relationInspectors = [];

    /**
     * InspectorAdapter constructor.
     * @param SchemaAttribute $schemaAttribute
     * @param array<AttributeInspectorInterface> $attributeInspectors
     */
    public function __construct(SchemaAttribute $schemaAttribute)
    {
        $this->schemaAttribute = $schemaAttribute;
    }

    /**
     * @param array<AttributeInspectorInterface> $attributeInspectors
     */
    public function setAttributeInspectors(array $attributeInspectors){
        $this->attributeInspectors = $attributeInspectors;
    }

    /**
     * @param array<RelationInspectorInterface> $relationInspectors
     */
    public function setRelationInspectors(array $relationInspectors){
        $this->relationInspectors = $relationInspectors;
    }


    public function getTitle()
    {
        return $this->schemaAttribute->title;
    }


    public function getName()
    {
        return $this->schemaAttribute->name;
    }


    public function getModelClass()
    {
        return $this->schemaAttribute->modelClass;
    }


    public function getDescription()
    {
        return $this->schemaAttribute->title;
    }

    public function getAttributes()
    {
        return $this->attributeInspectors;
    }

    /**
     * @return array<RelationInspectorInterface>
     */
    public function getRelations(){
        return $this->relationInspectors;
    }
}