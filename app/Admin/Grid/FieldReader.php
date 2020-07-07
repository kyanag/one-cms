<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\SchemaInspectorInterface;
use Kyanag\Form\Interfaces\Renderable;

class FieldReader implements FieldInspectorInterface
{

    /**
     * @var FieldAttribute
     */
    protected $fieldAttribute;

    /**
     * @var SchemaInspectorInterface
     */
    protected $schemaInspector;

    /**
     * @var ElementBuilder
     */
    protected $elementBuilder;

    /**
     * @var ColumnBuilder
     */
    protected $columnBuilder;

    public function __construct(SchemaInspectorInterface $schemaInspector, FieldAttribute $fieldAttribute, ElementBuilder $builder, ColumnBuilder $columnBuilder)
    {
        $this->schemaInspector = $schemaInspector;
        $this->fieldAttribute = $fieldAttribute;
        $this->elementBuilder = $builder;
        $this->columnBuilder = $columnBuilder;
    }


    public function ableFor(int $scene){
        return ($this->fieldAttribute->ableTo & $scene) == $scene;
    }


    public function getLabel()
    {
        return $this->fieldAttribute->label;
    }


    public function getName()
    {
        return $this->fieldAttribute->name;
    }

    /**
     * @return FieldAttribute
     */
    public function getOriginAttributes(){
       return $this->fieldAttribute;
    }


    public function getSchema()
    {
        return $this->schemaInspector;
    }

    /**
     * @return GridColumnInterface
     */
    public function toColumn(){
        $columnType = $this->fieldAttribute->columnType;
        $column = call_user_func_array([$this->columnBuilder, $columnType], [$this]);
        $column->boot();
        return $column;
    }

    /**
     * @return Renderable
     */
    public function toElement(){
        $inputType = $this->fieldAttribute->inputType;
        return call_user_func_array([$this->elementBuilder, $inputType], [$this]);
    }
}