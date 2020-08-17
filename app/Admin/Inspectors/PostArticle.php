<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\InputAttribute;

/**
 * Class PostArticle
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="文章",
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
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="主文章id",
     *     name="post_id",
     *     ableTo=0,
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $post_id;
    

    /**
     * @FieldAttribute(
     *     label="内容",
     *     name="content",
     *     ableTo=15,
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="wangEditor",
     *     columnType="raw"
     * )
     */
    public $content;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
     *     ableTo=0,
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
     *     ableTo=0,
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $updated_at;


    /**
     * @FieldAttribute(
     *     label="操作",
     *     name="id",
     *     ableTo=1,
     *     input = @InputAttribute(
     *         widget="text"
     *     ),
     *     columnType="action"
     * )
     */
    public $_actionBar;

}