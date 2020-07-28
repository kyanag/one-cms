<?php


namespace App\Admin\Annotations;


/**
 * Class FieldAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class FieldAttribute
{

    const ABLE_SHOW     = 0b00001;       //列表展示
    const ABLE_CREATE   = 0b00010;       //创建表单里面显示
    const ABLE_UPDATE   = 0b00100;       //更新表单里面显示
    const ABLE_SEARCH   = 0b01000;       //搜索栏
    const ABLE_SORT     = 0b10000;


    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $help;

    /**
     * @var int
     */
    public $ableTo = 15;

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var string
     */
    public $inputType = "text";

    /**
     * @var array
     */
    public $inputConfig = [];

    /**
     * @var string
     */
    public $columnType = "raw";

    /**
     * @var array
     */
    public $columnConfig = [];

}