<?php


namespace App\Admin\Annotations;

/**
 * 可建造的对象 稳定(Annotation)
 * Class BuildableObjectAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class BuildableObjectAttribute
{

    /**
     * 构造提供者
     * @var mixed
     */
    public $provider;

    /**
     * 需要构造的对象名称或者classname
     * @var string
     */
    public $name;

    /**
     * 对象属性
     * @var array
     */
    public $properties = [];

}