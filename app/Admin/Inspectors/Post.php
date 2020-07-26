<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use Kyanag\Form\Toolkits\Bootstrap3\Text;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Columns\RawColumn;

/**
 * Class Post
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="文章",
 *     name="posts",
 *     modelClass=\App\Models\Post::class
 * )
 */
class Post{

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
     *     label="title",
     *     name="title",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="category_id",
     *     name="category_id",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $category_id;
    

    /**
     * @FieldAttribute(
     *     label="keywords",
     *     name="keywords",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $keywords;
    

    /**
     * @FieldAttribute(
     *     label="description",
     *     name="description",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $description;
    

    /**
     * @FieldAttribute(
     *     label="author_id",
     *     name="author_id",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $author_id;
    

    /**
     * @FieldAttribute(
     *     label="image",
     *     name="image",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $image;
    

    /**
     * @FieldAttribute(
     *     label="rank",
     *     name="rank",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $rank;
    

    /**
     * @FieldAttribute(
     *     label="jump",
     *     name="jump",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $jump;
    

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