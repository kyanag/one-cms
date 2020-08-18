<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\CallableAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Supports\ObjectCreator;
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

    public function __construct(
        FieldAttribute $attribute,
        InspectorInterface $inspector
    )
    {
        $this->fieldAttribute = $attribute;
        $this->inspector = $inspector;
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
        if($this->fieldAttribute->input instanceof BuildableObjectAttribute){
            $this->fieldAttribute->input = app(ObjectCreator::class)->create($this->fieldAttribute->input);
        }
        return $this->fieldAttribute->input;
    }

    /**
     * @return GridColumnInterface
     */
    public function toColumn(){
        if($this->fieldAttribute->column instanceof BuildableObjectAttribute){
            $this->fieldAttribute->column = app(ObjectCreator::class)->create($this->fieldAttribute->column);
        }
        return $this->fieldAttribute->column;
    }

}