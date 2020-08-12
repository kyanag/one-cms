<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\InputAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\FieldInspectorAdapter;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\InspectorInterface;

class Factory
{

    public static function buildInspector($inspectorAnnotation, $related = true){
        $classAnnotationReader = new ClassAnnotationReader($inspectorAnnotation);

        $schemaAttribute = $classAnnotationReader->getClassAnnotation(SchemaAttribute::class);
        $fieldAttributes = $classAnnotationReader->getPropertyAnnotations(FieldAttribute::class);
        $relationAttributes = $schemaAttribute->relations;

        if($related){


        }
        $inspector = new InspectorAdapter($schemaAttribute);
        $inspector->setFieldInspectors(\Kyanag\Form\array_map($fieldAttributes, function($fieldAttribute, $index) use($inspector){
            return static::buildAttributeInspector($fieldAttribute, $inspector);
        }));
    }

    public static function buildAttributeInspector(FieldAttribute $attribute, InspectorInterface $inspector){
        return new FieldInspectorAdapter($attribute, $inspector);
    }

    public static function buildInput(InputAttribute $inputAttribute){

    }

    public static function buildColumn(ColumnAttribute $columnAttribute){

    }
}