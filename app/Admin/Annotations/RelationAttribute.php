<?php


namespace App\Admin\Annotations;

use App\Admin\Supports\Readable;

/**
 * Class RelationAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class RelationAttribute extends Readable
{

    const RELATION_HAS_ONE = "hasOne";
    const RELATION_BELONG_TO = "belongTo";
    const RELATION_HAS_MANY = "hasMany";

    /**
     *
     * @var string hasOne|belongTo|hasMany
     */
    public $type;

    /**
     * Inspector 的类名
     * @var string classname
     */
    public $related;

    /**
     * 外键名
     * @var string
     */
    public $foreignKey;

    /**
     * 主键名
     * @var string
     */
    public $ownerKey;
}