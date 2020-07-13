<?php


namespace App\Admin\Grid\Columns;


use App\Admin\Grid\Interfaces\GridColumnInterface;

class DataColumn implements GridColumnInterface
{

    /**
     * @var callable|string
     */
    public $content;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array<callable>
     */
    public $decorators = [];


    public function __invoke($model, $key, $index)
    {
        return $this->applyDecorators(
            $this->callContent($model, $key, $index)
        );
    }


    protected function callContent(...$args){
        if(is_null($this->content)){
            $this->content = function ($model, $key, $index){
                $key = $this->getName() ?: $key;
                return $model[$key];
            };
        }
        if(!is_callable($this->content)){
            return $this->content;
        }else{
            return call_user_func_array($this->content, $args);
        }
    }

    protected function applyDecorators($value){
        foreach ($this->decorators as $decorator){
            $value = call_user_func_array($decorator, [$value]);
        }
        return $value;
    }

    public function getLabel(){
        return $this->label;
    }

    public function getName(){
        return $this->name;
    }

}