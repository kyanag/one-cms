<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\CallableAttribute;
use App\Supports\UrlCreator;

/**
 * Class PostArticle
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="主内容",
 *     name="post_articles",
 *     modelClass=\App\Models\PostArticle::class,
 *     relations={
 *         "post": @RelationAttribute(
 *             type=RelationAttribute::RELATION_BELONG_TO,
 *             related=Post::class,
 *             ownerKey="id",
 *             foreignKey="post_id"
 *         )
 *     }
 * )
 */
class PostArticle extends Readable{


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
     *     label="主文章id",
     *     name="post_id",
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
    public $post_id;
    

    /**
     * @FieldAttribute(
     *     label="内容",
     *     name="content",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="ck-editor"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public $content;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
     *     name="created_at",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="datetime"
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
     *     name="post_id",
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