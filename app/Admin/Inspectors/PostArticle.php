<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\RelationAttribute;

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
class PostArticle{


    /**
     * @FieldAttribute(
     *     label="id",
     *     name="id",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="post_id",
     *     name="post_id",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $post_id;
    

    /**
     * @FieldAttribute(
     *     label="content",
     *     name="content",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $content;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $updated_at;

}