<?php


namespace App\Admin\Supports;


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
        }else {
            $this->target->properties[$name] = $value;
        }
        return $this;
    }

    public function getProperty($name)
    {
        if (property_exists($this->target, $name)) {
            return $this->target->{$name};
        }else {
            return $this->target->properties[$name];
        }
    }
}