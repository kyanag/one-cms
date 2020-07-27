<?php


namespace App\Admin\Grid;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class ModelInspectorFactory
 * @package App\Admin\Grid
 */
class ModelInspectorBuilder
{
    protected $reflectionObject;

    protected $columnFactory;

    protected $elementFactory;

    public function __construct(ColumnFactory $columnFactory, ElementFactory $elementFactory)
    {
        $this->columnFactory = $columnFactory;
        $this->elementFactory = $elementFactory;
    }

    protected function getAnnotationReader(){
        return app(AnnotationReader::class);
    }


    public function from($metaObject){
        $this->reflectionObject = new \ReflectionObject($metaObject);
        return $this;
    }

    public function with(){

    }

    /**
     * @param $annotationName
     * @return SchemaAttribute
     */
    public function getClassAnnotation($annotationName){
        return $this->getAnnotationReader()
            ->getClassAnnotation($this->reflectionObject, $annotationName);
    }

    /**
     * @param $annotationName
     * @return array<FieldAttribute>
     */
    public function getPropertyAnnotations($annotationName){
        $properties = $this->reflectionObject->getProperties(\ReflectionProperty::IS_PUBLIC);

        return array_map(function(\ReflectionProperty $property) use($annotationName){
            return $this->getAnnotationReader()
                ->getPropertyAnnotation($property, $annotationName);
        }, $properties);
    }

    /**
     * @return InspectorAdapter
     */
    public function built(){
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

        $inspector->setAttributeInspectors($attributeInspectors);
        $inspector->setRelationInspectors([]);
        return $inspector;
    }
}