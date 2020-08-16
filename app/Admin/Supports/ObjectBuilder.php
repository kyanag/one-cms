<?php


namespace App\Admin\Supports;


use Psy\Util\Str;

class ObjectBuilder
{

    protected $target;

    public function __construct($target)
    {
        $this->target = $target;
    }


    public function setProperty($name, $value)
    {
        if (property_exists($this->target, $name)) {
            $this->target->{$name} = $value;
            return $this;
        }else{
            $setter = $this->generateSetterMethod($name);
            if(method_exists($this->target, $setter)){
                $this->{$setter}($value);
            }else{
                $this->target->properties[$name] = $value;
            }
        }
        return $this;
    }

    public function getProperty($name)
    {
        if (property_exists($this->target, $name)) {
            return $this->target->{$name};
        }else {
            $getter = $this->generateGetterMethod($name);
            if(method_exists($this->target, $getter)){
                return $this->{$getter}();
            }else{
                return $this->target->properties[$name];
            }
        }
    }


    protected function generateGetterMethod($name){
        return "get" . \Illuminate\Support\Str::studly($name) . "Property";
    }

    protected function generateSetterMethod($name){
        return "set" . \Illuminate\Support\Str::studly($name) . "Property";;
    }
}