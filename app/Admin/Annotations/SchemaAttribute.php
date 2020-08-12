<?php


namespace App\Admin\Annotations;

use App\Admin\Supports\Readable;

/**
 * Class SchemaAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class SchemaAttribute extends Readable
{

    const TYPE_BASIC = 1;

    /**
     * @var string
     */
    public $title;

    /**
     * 名称
     * @var string
     */
    public $name;

    /**
     * 模型class
     * @var string
     */
    public $modelClass;

    /**
     * 类型
     * @var int
     */
    public $type = 1;


    /**
     * 默认排序
     * @var string
     */
    public $defaultOrderBy = "id desc";

    /**
     * 关系
     * @var array
     */
    public $relations = [];
}