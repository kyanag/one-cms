<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Supports\Factory;
use Kyanag\Form\Renderable;

class FieldInspectorAdapter implements FieldInspectorInterface
{

    /**
     * @var InspectorInterface
     */
    private $inspector;

    /**
     * @var FieldAttribute
     */
    private $fieldAttribute;


    private $elementFactory;


    private $columnFactory;

    public function __construct(
        FieldAttribute $attribute,
        InspectorInterface $inspector,
        ElementFactory $elementFactory = null,
        ColumnFactory $columnFactory = null
    )
    {
        $this->fieldAttribute = $attribute;
        $this->inspector = $inspector;
        $this->elementFactory = $elementFactory;
        $this->columnFactory = $columnFactory;
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
        return "";
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->fieldAttribute->name;
    }


    /**
     * @return string
     */
    public function getLabel(){
        return $this->fieldAttribute->label;
    }


    public function getRules()
    {
        return $this->fieldAttribute->rules;
    }

    /**
     * 虚拟属性，没有真实的数据库字段
     * @return bool
     */
    public function isVirtual()
    {
        return false;
    }

    /**
     * 是否可排序
     * @return bool
     */
    public function isOrderable()
    {
        return $this->ableFor($this->fieldAttribute::ABLE_SORT);
    }


    /**
     * 是否可搜索
     * @return bool
     */
    public function isSearchable()
    {
        return $this->ableFor($this->fieldAttribute::ABLE_SEARCH);
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
        return ($this->fieldAttribute->ableTo & $scene) == $scene;
    }


    /**
     * @return Renderable
     */
    public function toElement(){
        if($this->fieldAttribute->forForm !== null){
            return Factory::buildInput($this, $this->fieldAttribute->forForm);
        }

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
        if($this->fieldAttribute->forGrid !== null){
            return Factory::buildColumn($this->fieldAttribute->forGrid);
        }

        return app(ColumnFactory::class)->build(
            $this,
            $this->fieldAttribute->columnType,
            $this->fieldAttribute->columnConfig
        );
    }

}