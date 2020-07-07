<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\SchemaInspectorInterface;
use Doctrine\Common\Annotations\AnnotationReader;

class InspectorReader implements SchemaInspectorInterface
{
    /**
     * @var SchemaAttribute
     */
    protected $schemaAttribute;

    protected $inspector;

    /**
     * @var array<string, FieldInspectorInterface>
     */
    protected $_fields = null;

    public function __construct($inspector)
    {
        $this->inspector = $inspector;

        $this->schemaAttribute = $this->readSchema();
        if($this->schemaAttribute === null){
            throw new \Exception(get_class($inspector) . " 内容缺少！");
        }
    }

    public function title(){
        return $this->schemaAttribute->title;
    }

    public function modelClass(){
        return $this->schemaAttribute->modelClass;
    }

    /**
     * @return array<FieldInspectorInterface>
     */
    public function fields(){
        if($this->_fields === null){
            /** @var AnnotationReader $annotationReader */
            $annotationReader = app(AnnotationReader::class);

            $reflectionObject = new \ReflectionObject($this->inspector);

            $properties = $reflectionObject->getProperties(\ReflectionProperty::IS_PUBLIC);

            $fields = [];
            foreach ($properties as $property){
                /** @var FieldAttribute $fieldAttribute */
                $fieldAttribute = $annotationReader->getPropertyAnnotation($property, FieldAttribute::class);
                if(!is_null($fieldAttribute)){
                    //$fieldAttribute->name = $property->getName();

                    $fields[] = $this->readField($fieldAttribute);
                }
            }

            $this->_fields = $fields;
        }
        return $this->_fields;
    }


    protected function readField(FieldAttribute $fieldAttribute){
        return new FieldReader($this, $fieldAttribute, app(ElementBuilder::class), app(ColumnBuilder::class));
    }


    protected function readSchema(){
        /** @var AnnotationReader $annotationReader */
        $annotationReader = app(AnnotationReader::class);

        $schemaAttribute = $annotationReader->getClassAnnotation(new \ReflectionClass($this->inspector), SchemaAttribute::class);
        return $schemaAttribute;
    }


    public function getRules($scene = null){
        $rules = [];
        /** @var FieldAttribute $field */
        foreach ($this->fields() as $field){
            if(is_null($scene) or $field->ableFor($scene)){
                $rules[$field->getName()] = [
                    "required"
                ];
            }
        }
        return $rules;
    }

    public function getLabels(){
        $labels = [];
        /** @var FieldAttribute $field */
        foreach ($this->fields() as $field){
            $labels[$field->getName()] = $field->getLabel();
        }
        return $labels;
    }
}