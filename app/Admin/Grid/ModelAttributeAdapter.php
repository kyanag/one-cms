<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;
use Kyanag\Form\Interfaces\Renderable;

class ModelAttributeAdapter implements AttributeInspectorInterface
{

    /**
     * @var ModelInspectorInterface
     */
    private $modelInspector;

    /**
     * @var FieldAttribute
     */
    private $fieldAttribute;


    private $elementFactory;


    private $columnFactory;

    public function __construct(
        FieldAttribute $attribute,
        ElementFactory $elementFactory,
        ColumnFactory $columnFactory
    )
    {
        $this->fieldAttribute = $attribute;
        $this->elementFactory = $elementFactory;
        $this->columnFactory = $columnFactory;
    }


    public function setModelInspector(ModelInspectorInterface $modelInspector){
        $this->modelInspector = $modelInspector;
    }


    /**
     * @return ModelInspectorInterface
     */
    public function getModelInspector(){
        return $this->modelInspector;
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