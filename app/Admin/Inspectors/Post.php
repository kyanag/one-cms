<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\ColumnAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\InputAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Supports\Readable;

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
     *     forForm = @InputAttribute(
     *         widget="static-label"
     *     ),
     *     inputType="staticText",
     *     columnType="raw"
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="内容标题",
     *     name="title",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="分类",
     *     name="category_id",
     *     ableTo=0,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $category_id;
    

    /**
     * @FieldAttribute(
     *     label="关键字",
     *     name="keywords",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
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
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $description;
    

    /**
     * @FieldAttribute(
     *     label="作者",
     *     name="author_id",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $author_id;
    

    /**
     * @FieldAttribute(
     *     label="封面图",
     *     name="image",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $image;
    

    /**
     * @FieldAttribute(
     *     label="排序",
     *     name="rank",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $rank;
    

    /**
     * @FieldAttribute(
     *     label="链接",
     *     name="jump",
     *     ableTo=15,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $jump;
    

    /**
     * @FieldAttribute(
     *     label="创建时间",
     *     name="created_at",
     *     ableTo=0,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="修改时间",
     *     name="updated_at",
     *     ableTo=0,
     *     forForm = @InputAttribute(
     *         widget="text"
     *     ),
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $updated_at;
    

}