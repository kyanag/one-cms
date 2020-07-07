<?php


namespace App\Components;


use App\Admin\Grid\Interfaces\GridColumnInterface;
use Kyanag\Form\Interfaces\Renderable;

class GridView implements Renderable
{

    protected $caption;

    /**
     * @var array<GridColumnInterface>
     */
    protected $columns = [];

    /**
     * @var \Iterator
     */
    public $items;


    public function renderBegin(){
        return "<table class=\"table table-striped table-bordered table-hover\">";
    }


    public function renderCaption(){
        return $this->caption ? "<caption>{$this->caption}</caption>" : null;
    }

    public function renderHeader(){
        $_ = implode("", array_map(function(GridColumnInterface $column){
            return "<th>{$column->getLabel()}</th>";
        }, $this->columns));
        return "<thead><tr>{$_}</tr></thead>";
    }

    public function renderFooter(){

    }

    public function renderSearch(){

    }

    public function renderBody(){

        $tr_list = [];
        foreach($this->items as $index => $item){
            $tr_list[] = $this->renderItem($item, $index);
        }
        $_ = implode("", $tr_list);
        return "<tbody>{$_}</tbody>";
    }

    public function renderItem($attribute, $index){
        $th_list = [];

        /** @var GridColumnInterface $column */
        foreach ($this->columns as $column){
            $name = $column->getName();
            $th_str = ($column)($attribute, $name, $index);
            $th_list[] = "<td>{$th_str}</td>";
        }

        $tr_str = implode("", $th_list);
        return "<tr>{$tr_str}</tr>";
    }

    public function renderEnd(){
        return "</table>";
    }


    public function render()
    {
        return implode("", [
            $this->renderBegin(),
            $this->renderCaption(),
            $this->renderHeader(),
            $this->renderSearch(),
            $this->renderBody(),
            $this->renderFooter(),
            $this->renderEnd()
        ]);
    }


    public static function create($options = []){
        $static = new static();
        foreach ($options as $property => $option){
            $static->{$property} = $option;
        }
        return $static;
    }
}