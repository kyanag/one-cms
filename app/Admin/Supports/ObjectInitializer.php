<?php


namespace App\Admin\Supports;


class ObjectInitializer
{

    public static function initialize($object, $properties = []){
        foreach ($properties as $name => $value){
            static::setProperty($object, $name, $value);
        }
        return $object;
    }

    public static function setProperty($object, $name, $value)
    {
        if (property_exists($object, $name)) {
            $object->{$name} = $value;
            return $object;
        }else{
            $setter = static::generateSetterMethod($name);
            if(method_exists($object, $setter)){
                $object->{$setter}($value);
            }else{
                $object->properties[$name] = $value;
            }
        }
        return $object;
    }

    public static function getProperty($object, $name)
    {
        if (property_exists($object, $name)) {
            return $object->{$name};
        }else {
            $getter = static::generateGetterMethod($name);
            if(method_exists($object, $getter)){
                return $object->{$getter}();
            }else{
                return $object->properties[$name];
            }
        }
    }


    protected static function generateGetterMethod($name){
        return "get" . \Illuminate\Support\Str::studly($name) . "Property";
    }

    protected static function generateSetterMethod($name){
        return "set" . \Illuminate\Support\Str::studly($name) . "Property";
    }

}