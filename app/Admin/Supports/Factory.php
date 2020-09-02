<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\CallableAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Components\GridView;
use App\Admin\Grid\FieldInspectorAdapter;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Admin\Grid\RelationInspectorAdapter;

class Factory
{

    /**
     * @param $inspectorDocument
     * @param bool $related
     * @return InspectorInterface
     */
    public static function buildInspector($inspectorDocument, $related = true){
        $classAnnotationReader = new ClassAnnotationReader($inspectorDocument);

        $schemaAttribute = $classAnnotationReader->getClassAnnotation(SchemaAttribute::class);
        $fieldAttributes = $classAnnotationReader->getPropertyAnnotations(FieldAttribute::class);


        $inspector = new InspectorAdapter($schemaAttribute);
        $inspector->setFieldInspectors(\Kyanag\Form\array_map($fieldAttributes, function($fieldAttribute, $index) use($inspector, $inspectorDocument){


            return static::buildFieldInspector($fieldAttribute, $inspector, $inspectorDocument);
        }));

        if($related){
            $relationAttributes = $schemaAttribute->relations;
            $inspector->setRelationInspectors(\Kyanag\Form\array_map($relationAttributes, function($relationAttribute, $index) use($inspector){
                return static::buildRelationInspector($relationAttribute, $inspector);
            }));
        }
        return $inspector;
    }

    public static function buildFieldInspector(FieldAttribute $attribute, InspectorInterface $inspector, $inspectorDocument){
        $attribute->input = static::translate($attribute->input, $attribute, $inspectorDocument);
        $attribute->column = static::translate($attribute->column, $attribute, $inspectorDocument);

        return new FieldInspectorAdapter($attribute, $inspector);
    }

    public static function buildRelationInspector(RelationAttribute $relationAttribute, InspectorInterface $inspector){
        $foreignInspectorAttributeClass = $relationAttribute->related;

        $foreignInspectorAttributeObject = new $foreignInspectorAttributeClass;
        return new RelationInspectorAdapter($relationAttribute, $inspector, static::buildInspector($foreignInspectorAttributeObject, false));
    }

    /**
     * 读取 BuildableObjectAttribute::$properties 集合里面的值， 获取 CallableAttribute 真实的值
     * @param BuildableObjectAttribute $buildableObjectAttribute
     * @param FieldAttribute $attribute
     * @param $host
     * @return BuildableObjectAttribute
     */
    public static function translate(
        BuildableObjectAttribute $buildableObjectAttribute,
        FieldAttribute $attribute,
        $host)
    {

        foreach ($buildableObjectAttribute->properties as $name => $property){
            if($property instanceof CallableAttribute){
                $property->host = $host;

                $buildableObjectAttribute->properties[$name] = static::callCallableAttribute($property);
            }
        }
        $buildableObjectAttribute->properties['name'] = $attribute->name;
        $buildableObjectAttribute->properties['label'] = $attribute->label;

        return $buildableObjectAttribute;
    }

    protected static function callCallableAttribute(CallableAttribute $callableAttribute){
        $callable = [$callableAttribute->host, $callableAttribute->method];
        if(is_callable($callable) === false){
            $callable = $callableAttribute->method;
        }
        return call_user_func($callable);
    }


    /**
     * @param InspectorInterface $inspector
     * @param array<string> $relations
     */
    public static function grid(InspectorInterface $inspector, $relations = []){
        $columns = [];

        /** @var FieldInspectorInterface $field */
        foreach ($inspector->getFields() as $field){
            if($field->ableFor(FieldAttribute::ABLE_SHOW)){
                $columns[] = $field->toColumn();
            }
        }

        foreach ($relations as $relation){
            $foreignInspector = $inspector->getRelation($relation)->getForeignInspector();
            foreach ($foreignInspector->getFields() as $field){
                if($field->ableFor(FieldAttribute::ABLE_SHOW)){
                    $column = $field->toColumn();

                    $column->name = "{$relation}.{$column->name}";

                    $columns[] = $column;
                }
            }
        }

        $gridView = GridView::create([
            'caption' => "{$inspector->getTitle()} 列表",
            'columns' => $columns,
        ]);
//        $gridView = GridView::create([
//            'caption' => "{$inspector->getTitle()} 列表",
//            'columns' => $columns,
//        ]);
        return $gridView;
    }
}