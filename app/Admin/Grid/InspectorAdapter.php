<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;

class InspectorAdapter implements InspectorInterface
{

    /**
     * @var SchemaAttribute
     */
    private $schemaAttribute;

    /**
     * @var array<FieldInspectorInterface>
     */
    private $fieldInspectors = [];

    /**
     * @var array<RelationInspectorInterface>
     */
    private $relationInspectors = [];

    /**
     * InspectorAdapter constructor.
     * @param SchemaAttribute $schemaAttribute
     */
    public function __construct(SchemaAttribute $schemaAttribute)
    {
        $this->schemaAttribute = $schemaAttribute;
    }

    /**
     * @param array<FieldInspectorInterface> $fieldInspectors
     */
    public function setFieldInspectors(array $fieldInspectors){
        $this->fieldInspectors = $fieldInspectors;
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

    public function getFields()
    {
        return $this->fieldInspectors;
    }

    /**
     * @return array<RelationInspectorInterface>
     */
    public function getRelations(){
        return $this->relationInspectors;
    }

    /**
     * @param $name
     * @return RelationInspectorInterface|mixed
     */
    public function getRelation($name)
    {
        return $this->relationInspectors[$name];
    }
}