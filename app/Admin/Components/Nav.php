<?php


namespace App\Admin\Components;


use Kyanag\Form\Renderable;

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