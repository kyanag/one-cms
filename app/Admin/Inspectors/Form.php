<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\CallableAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Decorators\BadgeDecorator;
use App\Supports\UrlCreator;

/**
 * Class Form
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="表单",
 *     name="forms",
 *     modelClass="\App\Models\Form",
 *     relations={
 *         "inputs": @RelationAttribute(
 *             type="hasMany",
 *             related=FormInput::class,
 *             ownerKey="id",
 *             foreignKey="form_id"
 *         )
 *     }
 * )
 */
class Form{

    /**
     * @FieldAttribute(
     *     label="id",
     *     name="id",
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
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="site_id",
     *     name="site_id",
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
    public $site_id;
    

    /**
     * @FieldAttribute(
     *     label="表单名称",
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
     *     label="表单标题",
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
     *     label="分类",
     *     name="group_id",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="radio",
     *         properties={
     *             "value"=20,
     *             "options":{
     *                 20:"文章",
     *                 21:"栏目",
     *                 22:"问卷",
     *             }
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="using",
     *         properties={
     *             "options":{
     *                 20:"文章",
     *                 21:"栏目",
     *                 22:"问卷",
     *             },
     *             "decorators":{
     *                @BadgeDecorator()
     *             }
     *         }
     *     )
     * )
     */
    public $group_id;
    

    /**
     * @FieldAttribute(
     *     label="简介",
     *     name="desc",
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
    public $desc;
    

    /**
     * @FieldAttribute(
     *     label="状态",
     *     name="status",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="radio",
     *         properties={
     *             "value"=0,
     *             "options":{
     *                 0:"正常",
     *                 1:"隐藏"
     *             }
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="using",
     *         properties={
     *             "options":{
     *                 0:"正常",
     *                 1:"隐藏"
     *             },
     *             "decorators":{
     *                @BadgeDecorator()
     *             }
     *         }
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


    /**
     * @FieldAttribute(
     *     label="操作",
     *     name="id",
     *     ableTo=1,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="action",
     *         properties={
     *             "urlCreator":@CallableAttribute(method="getUrlCreator"),
     *         }
     *     )
     * )
     */
    public $_actionBar;


    public function getUrlCreator(){
        $urlCreator = new UrlCreator("form");
        return $urlCreator;
    }
}