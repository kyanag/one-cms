<?php


namespace App\Admin\Components;


use Kyanag\Form\Renderable;

class Breadcrumb implements Renderable
{
    protected $breadcrumbs = [];

    /**
     * @param array $breadcrumb
     */
    public function push($breadcrumb){
        $this->breadcrumbs[] = $breadcrumb;
    }

    public function render()
    {
        return implode("", [
            '<ol class="breadcrumb">',
            $this->renderBody(),
            "</ol>"
        ]);
    }

    protected function renderBody(){
        return implode("", array_map(function($breadcrumb){
            return "<li class=\"breadcrumb-item\"><a href=\"{$breadcrumb['url']}\">{$breadcrumb['title']}</a></li>";
        }, $this->breadcrumbs));
    }
}