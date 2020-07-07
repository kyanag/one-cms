<?php


namespace App\Components;


use Kyanag\Form\Interfaces\Renderable;

class Nav implements Renderable
{

    public $items = [];


    public function render()
    {
        return view("admin::components.nav", [
            'menus' => $this->items
        ])->render();
    }

}