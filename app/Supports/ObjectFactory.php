<?php


namespace App\Supports;


use App\OneGrid\Annotations\SerializableProperty;
use App\OneGrid\Serializable;
use Doctrine\Common\Annotations\AnnotationReader;

class ObjectFactory
{

    /**
     * @var static
     */
    protected $parentScope;

    protected $vars = [];

    public function setVar($name, $reference){
        $this->vars[$name] = $reference;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getVar($name){
        if(isset($this->vars[$name])){
            return $this->vars[$name];
        }
        if(!is_null($this->parentScope)){
            return $this->parentScope->getVar($name);
        }
        return null;
    }

    public function hasVar($name){
        if(isset($this->vars[$name])){
            return true;
        }
        if(!is_null($this->parentScope)){
            return $this->parentScope->hasVar($name);
        }
        return false;
    }

    /**
     * @param $config
     * @return Serializable
     * @throws \Exception
     */
    public function createObject($config){
        $class = $config['class'];
        unset($config['class']);

        $object = new $class;
        return $this->configure($object, $config);
    }


    public function configure(Serializable $serializable, $values = []){
        /** @var AnnotationReader $annotationReader */
        $annotationReader = app(AnnotationReader::class);

        $ref = new \ReflectionObject($serializable);

        foreach ($values as $name => $value){
            $property = $ref->getProperty($name);

            $name = $property->getName();
            /** @var SerializableProperty $serializableProperty */
            $serializableProperty = $annotationReader->getPropertyAnnotation($property, SerializableProperty::class);
            if(!is_null($serializableProperty)){
                if($serializableProperty->isReference){
                    if(!$this->hasVar($serializableProperty->target)){
                        throw new \Exception("Property not reference {$name} => {$serializableProperty->target}");
                    }
                    $value = $this->getVar($serializableProperty->target);
                }

                switch ($serializableProperty->type){
                    case SerializableProperty::TYPE_GENERAL:
                        $value = $this->createObject($value);
                        break;
                    case SerializableProperty::TYPE_GENERAL_ARRAY:
                        $value = array_map(function($item){
                            return $this->createObject($item);
                        }, $value);
                        break;
                }
            }
            $serializable->setProperty($name, $value);
        }
        return $serializable;
    }

    public function serialize(Serializable $serializable){
        /** @var AnnotationReader $annotationReader */
        $annotationReader = app(AnnotationReader::class);

        $ref = new \ReflectionObject($serializable);
        $properties = $ref->getProperties(\ReflectionProperty::IS_PUBLIC);

        $_ = [
            'class' => static::class,
        ];
        /** @var \ReflectionProperty $property */
        foreach ($properties as $property){
            $name = $property->getName();
            $value = $property->getValue($serializable);

            /** @var SerializableProperty $serializableProperty */
            $serializableProperty = $annotationReader->getPropertyAnnotation($property, SerializableProperty::class);
            if($serializableProperty->isReference){
                $value = $serializableProperty->target ?: "&{$name}";
            }else{
                switch ($serializableProperty->type){
                    case SerializableProperty::TYPE_GENERAL:
                        $value = $value->serialize();
                        break;
                    case SerializableProperty::TYPE_GENERAL_ARRAY:
                        $value = array_map(function($item){
                            return $item->serialize();
                        }, $value);
                        break;
                    case SerializableProperty::TYPE_REFERENCE:
                        $value = $serializableProperty->target;
                        break;
                }
            }
            $_[$name] = $value;
        }
        return $_;
    }


    public static function extend(ObjectFactory $objectFactory){
        $static = new static();
        $static->parentScope = $objectFactory;
        return $static;
    }
}