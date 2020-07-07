<?php


namespace App\Components;


use Kyanag\Form\Interfaces\Renderable;

class Tabs implements Renderable
{

    protected $tabs = [];


    public function addTab($name, $id, $tab){
        if(is_callable($tab)){
            $tab = call_user_func_array($tab, [$this, $name, $id]);
        }
        $this->tabs[] = $tab;
        return $tab;
    }

    public function render()
    {
        // TODO: Implement render() method.
    }
}