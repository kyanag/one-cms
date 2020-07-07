<?php


namespace App\Supports;


class Tree
{

    protected $items;

    protected $idName;

    protected $fidName;



    public function __construct(array $items, $idName = "id", $fidName = "parent_id")
    {
        $this->items = $items;
        $this->idName = $idName;
        $this->fidName = $fidName;
    }

    /**
     * 返回的是多树
     * @return array
     */
    public function toTree(){
        $items = array_column($this->items, null, $this->idName);

        $tree = [];
        foreach ($items as $id => &$item){
            if(isset($items[$item[$this->fidName]])){
                if(!isset($items[$item[$this->fidName]]['children'])){
                    $items[$item[$this->fidName]]['children'] = [];
                }
                $items[$item[$this->fidName]]['children'][] = &$item;
            }else{
                $tree[] = &$item;
            }
        }
        return $tree;
    }


    public static function tree2List($node, $childrenName = "children", array &$list = []){
        $children = @$node[$childrenName];
        unset($node[$childrenName]);

        $list[] = $node;
        if(is_array($children) == false){
            return;
        }

        foreach ($children as $child){
            $child['depth'] = $node['depth'] + 1;

            static::tree2List($child, $childrenName, $list);
        }
        return;
    }

    public function toTreeList(){
        $trees = $this->toTree();

        //var_dump($trees);exit();
        $items = [];
        foreach ($trees as $node){
            $node['depth'] = 1;
            static::tree2List($node, "children", $items);
        }
        return $items;
    }

}