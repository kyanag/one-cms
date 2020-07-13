<?php


namespace App\Admin\Grid\Interfaces;


use Kyanag\Form\Interfaces\Renderable;

interface AttributeInspectorInterface
{

    /**
     * @return ModelInspectorInterface
     */
    public function getModelInspector();

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getLabel();


    /**
     * 虚拟属性，没有真实的数据库字段
     * @return bool
     */
    public function isVirtual();

    /**
     * 是否可排序
     * @return bool
     */
    public function isOrderable();


    /**
     * 是否可搜索
     * @return bool
     */
    public function isSearchable();


    /**
     * 是否可用
     * @return mixed
     */
    public function isUsable();

    /**
     * @param int|mixed $scene 场景
     * @return bool
     */
    public function ableFor($scene);


    /**
     * @return Renderable
     */
    public function toElement();

    /**
     * @return GridColumnInterface
     */
    public function toColumn();
}