<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use Kyanag\Form\Renderable;

class AttributeInspector implements AttributeInspectorInterface
{

    private $inspector;

    private $config = [];

    public function __construct(InspectorInterface $inspector, $config = [])
    {
        $this->inspector = $inspector;
        $this->config = $config;
    }

    /**
     * @return InspectorInterface
     */
    public function getInspector(){
        return $this->inspector;
    }

    /**
     * @return string
     */
    public function getId(){
        return @$this->config['id'] ?: "";
    }

    /**
     * @return string
     */
    public function getName(){
        return @$this->config['name'];
    }


    /**
     * @return string
     */
    public function getLabel(){
        return @$this->config['label'] ?: $this->getName();
    }


    public function getRules()
    {
        return @$this->config['rules'] ?: [];
    }

    /**
     * 虚拟属性，没有真实的数据库字段
     * @return bool
     */
    public function isVirtual()
    {
        return boolval(@$this->config['virtual']);
    }

    /**
     * 是否可排序
     * @return bool
     */
    public function isOrderable()
    {
        return $this->ableFor(FieldAttribute::ABLE_SORT);
    }


    /**
     * 是否可搜索
     * @return bool
     */
    public function isSearchable()
    {
        return $this->ableFor(FieldAttribute::ABLE_SEARCH);
    }


    /**
     * 是否可用
     * @return mixed
     */
    public function isUsable()
    {
        return true;
    }

    /**
     * @param int|mixed $scene 场景
     * @return bool
     */
    public function ableFor($scene){
        return (intval(@$this->config['ableTo']) & $scene) == $scene;
    }


    /**
     * @return Renderable
     */
    public function toElement(){
        return $this->elementFactory->build(
            $this,
            $this->fieldAttribute->inputType,
            $this->fieldAttribute->inputConfig
        );
    }

    /**
     * @return GridColumnInterface
     */
    public function toColumn(){
        return $this->columnFactory->build(
            $this,
            $this->fieldAttribute->columnType,
            $this->fieldAttribute->columnConfig
        );
    }
}