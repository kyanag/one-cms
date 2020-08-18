<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\CallableAttribute;
use App\Admin\Grid\Decorators\BadgeDecorator;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Supports\Readable;
use App\Models\Category as CategoryModel;
use App\Supports\Tree;
use App\Supports\UrlCreator;

/**
 * Class Category
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="栏目",
 *     name="categories",
 *     modelClass=CategoryModel::class
 * )
 */
class Category extends Readable{

    /**
     * @FieldAttribute(
     *     label="主键",
     *     name="id",
     *     ableTo=17,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="checkbox"
     *     )
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="store_id",
     *     name="store_id",
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
    public $store_id;
    

    /**
     * @FieldAttribute(
     *     label="栏目名称",
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
     *     label="关键词",
     *     name="keywords",
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
    public $keywords;
    

    /**
     * @FieldAttribute(
     *     label="简介",
     *     name="description",
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
    public $description;
    

    /**
     * @FieldAttribute(
     *     label="上级栏目",
     *     name="parent_id",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="select",
     *         properties={
     *             "options":@CallableAttribute(method="getCategoryIdOptions")
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="using",
     *         properties={
     *             "options":@CallableAttribute(method="getCategoryIdOptions")
     *         }
     *     )
     * )
     */
    public $parent_id;
    

    /**
     * @FieldAttribute(
     *     label="类型",
     *     name="type",
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
    public $type;
    

    /**
     * @FieldAttribute(
     *     label="地址",
     *     name="url",
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
    public $url;
    

    /**
     * @FieldAttribute(
     *     label="状态",
     *     name="status",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="radio",
     *         properties={
     *             "options":{0:"显示", 1:"不显示"}
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="using",
     *         properties={
     *             "options":{0:"显示", 1:"不显示"},
     *             "decorators":{
     *                 @BadgeDecorator()
     *              }
     *         }
     *     )
     * )
     */
    public $status;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
     *     name="created_at",
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
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="修改时间",
     *     name="updated_at",
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
    public $updated_at;
    

    /**
     * @FieldAttribute(
     *     label="bg_img",
     *     name="bg_img",
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
    public $bg_img;


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



    public function getCategoryIdOptions(){
        $categories = \App\Models\Category::query()->select(
            "id", "parent_id", "title"
        )->get();

        $tree = new Tree($categories->toArray());

        $items = $tree->toTreeList();

        $options = [
            0 => "根"
        ];

        foreach ($items as $item){
            $options[$item['id']] = str_repeat("—— ", $item['depth']) .  " {$item['title']}";
        }
        return $options;
    }

    public function getUrlCreator(){
        return new UrlCreator("category");
    }
}