<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Grid\Interfaces\ObjectBuilderProvider;

class ObjectCreator
{

    protected $providers = [];


    public function create(BuildableObjectAttribute $attribute){
        return $this
            ->getProvider($attribute->provider)
            ->create($attribute->name, $attribute->properties);
    }

    protected function getProvider($provider){
        if(isset($this->providers[$provider])){
            return $this->providers[$provider];
        }else{
            throw new \RuntimeException("ObjectBuilder::providers[{$provider}] not exists!");
        }
    }


    public function register($name, ObjectBuilderProvider $provider){
        $this->providers[$name] = $provider;
    }

    public function hasProvider($name){
        return isset($this->providers[$name]);
    }
}