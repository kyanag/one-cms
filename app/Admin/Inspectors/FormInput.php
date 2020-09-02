<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\SchemaAttribute;

/**
 * Class FormInput
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="表单字段",
 *     name="form_inputs",
 *     modelClass="\App\Models\FormInput"
 * )
 */
class FormInput{

    /**
     * @FieldAttribute(
     *     label="id",
     *     name="id",
     *     ableTo=4,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="hidden"
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
     *     label="form_id",
     *     name="form_id",
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
    public $form_id;
    

    /**
     * @FieldAttribute(
     *     label="字段名称",
     *     name="name",
     *     help="代码调用名称",
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
     *     label="字段标题",
     *     name="label",
     *     help="字段显示名称",
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
    public $label;
    

    /**
     * @FieldAttribute(
     *     label="类型",
     *     name="type",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="select",
     *         properties={
     *             "options":{"text": "文本"}
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $type;
    

    /**
     * @FieldAttribute(
     *     label="字段排序",
     *     name="index",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="range",
     *         properties={
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $index;
    

    /**
     * @FieldAttribute(
     *     label="表单配置",
     *     name="properties",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="textarea",
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $properties;
    

    /**
     * @FieldAttribute(
     *     label="字段状态",
     *     name="status",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="radio",
     *         properties={
     *             "options":{0: "正常", 1: "隐藏"},
     *             "value": 0
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $status;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
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
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
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
    public $updated_at;
    

}