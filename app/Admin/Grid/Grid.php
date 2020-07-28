<?php


namespace App\Admin\Grid;


use App\Admin\Grid\Interfaces\InspectorInterface;
use Kyanag\Form\Interfaces\ComponentInterface;
use Kyanag\Form\Interfaces\Renderable;

class Grid implements Renderable
{

    public $title;

    public $description;

    /** @var InspectorInterface */
    protected $inspector;

    public function renderActionBar(){
        return "";
    }

    public function renderTable(){

    }

    public function renderPager(){

    }

    public function render()
    {
        return <<<TPL
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-fw fa-cog"></i>{ $this->title }<small>{ $this->description }</small></div>
    <div class="panel-body" style="border-bottom: 1px solid #f4f4f4">
        {$this->renderActionBar()}
    </div>
    <div class="panel-body">
        {$this->renderTable()}
        {$this->renderPager()}
    </div>
    <div class="panel-footer">

    </div>
</div>
TPL;

    }
}