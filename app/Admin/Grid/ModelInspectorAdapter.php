<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;

class ModelInspectorAdapter implements ModelInspectorInterface
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
     * ModelInspectorAdapter constructor.
     * @param SchemaAttribute $schemaAttribute
     * @param array<AttributeInspectorInterface> $attributeInspectors
     */
    public function __construct(SchemaAttribute $schemaAttribute, array $attributeInspectors)
    {
        $this->schemaAttribute = $schemaAttribute;
        $this->attributeInspectors = $attributeInspectors;

        foreach ($this->attributeInspectors as $attributeInspector){
            $attributeInspector->setModelInspector($this);
        }
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
}