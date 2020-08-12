<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use Doctrine\Common\Annotations\AnnotationReader;

class ClassAnnotationReader
{
    protected $reflectionObject;

    public function __construct($attribute)
    {
        $this->reflectionObject = new \ReflectionObject($attribute);
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

    private function getAnnotationReader(){
        return app(AnnotationReader::class);
    }
}