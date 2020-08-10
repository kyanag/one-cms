<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Decorators\BadgeDecorator;
use App\Admin\Grid\Options\Categories;
use App\Admin\Annotations\SchemaAttribute;
use App\Models\Category as CategoryModel;

/**
 * Class Category
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="栏目",
 *     name="categories",
 *     modelClass=CategoryModel::class
 * )
 */
class Category{

    /**
     * @FieldAttribute(
     *     label="#",
     *     name="id",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="checkbox"
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="store_id",
     *     name="store_id",
     *     ableTo=0,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $store_id;
    

    /**
     * @FieldAttribute(
     *     label="栏目名称",
     *     name="title",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="关键词",
     *     name="keywords",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $keywords;
    

    /**
     * @FieldAttribute(
     *     label="简介",
     *     name="description",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $description;
    

    /**
     * @FieldAttribute(
     *     label="上级栏目",
     *     name="parent_id",
     *     ableTo=15,
     *     inputType="select",
     *     inputConfig={
     *         "options": @Categories()
     *     },
     *     columnType="using",
     *     columnConfig={
     *         "options": @Categories()
     *     }
     * )
     */
    public $parent_id;
    

    /**
     * @FieldAttribute(
     *     label="类型",
     *     name="type",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $type;
    

    /**
     * @FieldAttribute(
     *     label="地址",
     *     name="url",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $url;
    

    /**
     * @FieldAttribute(
     *     label="状态",
     *     name="status",
     *     ableTo=15,
     *     inputType="radio",
     *     inputConfig={
     *         "options": {0:"显示", 1:"不显示"}
     *     },
     *     columnType="using",
     *     columnConfig={
     *         "options": {0:"显示", 1:"不显示"},
     *         "decorators":{
     *             @BadgeDecorator()
     *         }
     *     }
     * )
     */
    public $status;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
     *     name="created_at",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="修改时间",
     *     name="updated_at",
     *     ableTo=1,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $updated_at;
    

    /**
     * @FieldAttribute(
     *     label="bg_img",
     *     name="bg_img",
     *     ableTo=0,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $bg_img;


    /**
     * @FieldAttribute(
     *     label="操作",
     *     name="id",
     *     ableTo=1,
     *
     *     columnType="action"
     * )
     */
    public $_actionBar;



    //public static function
}