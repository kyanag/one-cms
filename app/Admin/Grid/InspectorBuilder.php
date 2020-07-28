<?php


namespace App\Admin\Grid;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\SchemaAttribute;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class InspectorFactory
 * @package App\Admin\Grid
 */
class InspectorBuilder
{
    protected $reflectionObject;

    protected $columnFactory;

    protected $elementFactory;

    public function __construct(ColumnFactory $columnFactory, ElementFactory $elementFactory)
    {
        $this->columnFactory = $columnFactory;
        $this->elementFactory = $elementFactory;
    }


    public function from($metaObject){
        $this->reflectionObject = new \ReflectionObject($metaObject);
        return $this;
    }

    public function with(){

    }

    /**
     * @param $related bool 是否加载关系
     * @return InspectorAdapter
     */
    public function built($related = true){
        $schemaAttribute = $this->getClassAnnotation(SchemaAttribute::class);

        $fieldAttributes = $this->getPropertyAnnotations(FieldAttribute::class);

        $inspector = new InspectorAdapter($schemaAttribute);

        $attributeInspectors = array_map(function(FieldAttribute $fieldAttribute) use($inspector){
            return new AttributeInspectorAdapter(
                $fieldAttribute,
                $inspector,
                $this->elementFactory,
                $this->columnFactory
            );
        }, $fieldAttributes);

        $relationInspectors = [];
        if($related){
            $inspectorBuilder = clone $this;
            $relationInspectors = array_map(function (RelationAttribute $attribute) use($inspector, $inspectorBuilder){
                $foreignInspectorAttributeClass = $attribute->related;

                $foreignInspectorAttributeObject = new $foreignInspectorAttributeClass;
                return new RelationInspectorAdapter($attribute, $inspector, $inspectorBuilder->from($foreignInspectorAttributeObject)->built(false));
            }, $schemaAttribute->relations);
        }

        $inspector->setAttributeInspectors($attributeInspectors);
        $inspector->setRelationInspectors($relationInspectors);
        return $inspector;
    }


    private function getAnnotationReader(){
        return app(AnnotationReader::class);
    }

    /**
     * @param $annotationName
     * @return SchemaAttribute
     */
    private function getClassAnnotation($annotationName){
        return $this->getAnnotationReader()
            ->getClassAnnotation($this->reflectionObject, $annotationName);
    }

    /**
     * @param $annotationName
     * @return array<FieldAttribute>
     */
    private function getPropertyAnnotations($annotationName){
        $properties = $this->reflectionObject->getProperties(\ReflectionProperty::IS_PUBLIC);

        return array_map(function(\ReflectionProperty $property) use($annotationName){
            return $this->getAnnotationReader()
                ->getPropertyAnnotation($property, $annotationName);
        }, $properties);
    }
}