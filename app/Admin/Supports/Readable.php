<?php


namespace App\Admin\Supports;

/**
 * Class Readable
 * @package App\Admin\Supports
 * @Annotation
 */
abstract class Readable
{


    public function toArray(){
        $reflectionObject = new \ReflectionObject($this);

        /** @var \ReflectionProperty[] $properties */
        $properties = $reflectionObject->getProperties(\ReflectionProperty::IS_PUBLIC);

        $export = [
            'class' => get_class($this),
        ];
        foreach ($properties as $property){
            $export[$property->getName()] = $property->getValue($this);
        }
        return $export;
    }

}