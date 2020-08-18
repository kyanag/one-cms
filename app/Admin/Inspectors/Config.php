<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\BuildableObjectAttribute;

/**
 * Class Category
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="系统设置",
 *     name="configs",
 *     modelClass="\App\Models\Config"
 * )
 */
class Config extends Readable{

    /**
     * @FieldAttribute(
     *     label="id",
     *     name="id",
     *     ableTo=1,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="名称",
     *     name="title",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="调用名",
     *     name="name",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $name;
    

    /**
     * @FieldAttribute(
     *     label="值",
     *     name="value",
     *     ableTo=0,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $value;
    

    /**
     * @FieldAttribute(
     *     label="帮助",
     *     name="help",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $help;
    

    /**
     * @FieldAttribute(
     *     label="分组",
     *     name="group_id",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $group_id;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
     *     name="created_at",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="修改时间",
     *     name="updated_at",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $updated_at;
    

}