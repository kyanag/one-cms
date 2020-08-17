<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\RuntimeValueAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\FieldInspectorAdapter;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\RelationInspectorAdapter;

class Factory
{

    /**
     * @param $inspectorAnnotation
     * @param bool $related
     * @return InspectorInterface
     */
    public static function buildInspector($inspectorAnnotation, $related = true){
        $classAnnotationReader = new ClassAnnotationReader($inspectorAnnotation);

        $schemaAttribute = $classAnnotationReader->getClassAnnotation(SchemaAttribute::class);
        $fieldAttributes = $classAnnotationReader->getPropertyAnnotations(FieldAttribute::class);


        $inspector = new InspectorAdapter($schemaAttribute);
        $inspector->setFieldInspectors(\Kyanag\Form\array_map($fieldAttributes, function($fieldAttribute, $index) use($inspector){
            return static::buildFieldInspector($fieldAttribute, $inspector);
        }));

        if($related){
            $relationAttributes = $schemaAttribute->relations;
            $inspector->setRelationInspectors(\Kyanag\Form\array_map($relationAttributes, function($relationAttribute, $index) use($inspector){
                return static::buildRelationInspector($relationAttribute, $inspector);
            }));
        }
        return $inspector;
    }

    public static function buildFieldInspector(FieldAttribute $attribute, InspectorInterface $inspector){
        $attribute->input = static::translate($attribute->input);
        $attribute->column = static::translate($attribute->column);

        return new FieldInspectorAdapter($attribute, $inspector);
    }

    public static function buildRelationInspector(RelationAttribute $relationAttribute, InspectorInterface $inspector){
        $foreignInspectorAttributeClass = $relationAttribute->related;

        $foreignInspectorAttributeObject = new $foreignInspectorAttributeClass;
        return new RelationInspectorAdapter($relationAttribute, $inspector, static::buildInspector($foreignInspectorAttributeObject, false));
    }


    public static function translate(
        BuildableObjectAttribute $buildableObjectAttribute,
        FieldAttribute $fieldAttribute,
        SchemaAttribute $schemaAttribute,
        $host)
    {
        /** @var ObjectCreator $objectCreator */
        $objectCreator = app("objectCreator");


    }
}