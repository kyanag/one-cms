<?php

namespace App\Admin\Inspectors;


use App\Admin\Annotations\CallableAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Supports\UrlCreator;

/**
 * Class Post
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="文章",
 *     name="posts",
 *     modelClass=\App\Models\Post::class,
 *     relations={
 *         "article": @RelationAttribute(
 *             type="hasOne",
 *             related=PostArticle::class,
 *             ownerKey="id",
 *             foreignKey="post_id"
 *         )
 *     }
 * )
 */
class Post extends Readable{

    /**
     * @FieldAttribute(
     *     label="主键",
     *     name="id",
     *     ableTo=5,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="static-text"
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
     *     label="内容标题",
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
     *     name="category_id",
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
    public $category_id;
    

    /**
     * @FieldAttribute(
     *     label="关键字",
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
     *     label="作者",
     *     name="author_id",
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
    public $author_id;
    

    /**
     * @FieldAttribute(
     *     label="封面图",
     *     name="image",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="ajax-file"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $image;
    

    /**
     * @FieldAttribute(
     *     label="排序",
     *     name="rank",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text",
     *         properties={
     *             "style": "width:200px"
     *         }
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $rank;
    

    /**
     * @FieldAttribute(
     *     label="链接",
     *     name="jump",
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
    public $jump;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
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
     *     label="修改时间",
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
        $urlCreator = new UrlCreator("post");
        $urlCreator->setDefaultQuery(['category_id' => app("request")->input("category_id")]);
        return $urlCreator;
    }
}