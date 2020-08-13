<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\InputAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\ColumnAttribute;
use App\Admin\Grid\FieldInspectorAdapter;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\RelationInspectorAdapter;
use Kyanag\Form\Component;

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
        if($attribute->forForm instanceof InputAttribute){
            $attribute->forForm->setFieldAttribute($attribute);
            $attribute->forForm->setInspector($inspector);
        }

        return new FieldInspectorAdapter($attribute, $inspector);
    }

    public static function buildRelationInspector(RelationAttribute $relationAttribute, InspectorInterface $inspector){
        $foreignInspectorAttributeClass = $relationAttribute->related;

        $foreignInspectorAttributeObject = new $foreignInspectorAttributeClass;
        return new RelationInspectorAdapter($relationAttribute, $inspector, static::buildInspector($foreignInspectorAttributeObject, false));
    }

    /**
     * @param InputAttribute $inputAttribute
     * @return Component
     */
    public static function buildInput(FieldInspectorInterface $fieldInspector, InputAttribute $inputAttribute){
        $args = $inputAttribute->widgetArgs;
        $args['name'] = $fieldInspector->getName();
        $args['label'] = $fieldInspector->getLabel();
        return createElement($inputAttribute->widget, $args);
    }

    /**
     * @param ColumnAttribute $columnAttribute
     * @return GridColumnInterface
     */
    public static function buildColumn(FieldInspectorInterface $fieldInspector, ColumnAttribute $columnAttribute){

    }
}