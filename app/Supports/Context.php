<?php


namespace App\Supports;


class Context implements \ArrayAccess
{

    protected $env = [];


    public function set($name, $value){
        $this->env[$name] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->env[$offset]);
    }


    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }


    public function offsetGet($offset)
    {
        return $this->env[$offset];
    }


    public function offsetExists($offset)
    {
        return isset($this->env[$offset]);
    }
}