<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use Kyanag\Form\Toolkits\Bootstrap3\Text;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Columns\RawColumn;

/**
 * Class Group
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="分组",
 *     name="groups",
 *     modelClass=\App\Models\Group::class
 * )
 */
class Group{

    /**
     * @FieldAttribute(
     *     label="主键",
     *     name="id",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="标题",
     *     name="title",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="图标",
     *     name="icon",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $icon;
    

    /**
     * @FieldAttribute(
     *     label="类型",
     *     name="type",
     *     ableTo=15,
     *     inputType="select",
     *     inputConfig={"options":{1:"配置"}},
     *     columnType="using",
     *     columnConfig={"options":{1:"配置"}}
     * )
     */
    public $type;
    

    /**
     * @FieldAttribute(
     *     label="介绍",
     *     name="desc",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $desc;
    

    /**
     * @FieldAttribute(
     *     label="状态",
     *     name="status",
     *     ableTo=15,
     *     inputType="select",
     *     inputConfig={"options":{0:"正常", 1:"不显示"}},
     *     columnType="using",
     *     columnConfig={"options":{0:"正常", 1:"不显示"}}
     * )
     */
    public $status;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $updated_at;
    

}