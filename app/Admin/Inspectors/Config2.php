<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use Kyanag\Form\Toolkits\Bootstrap3\Text;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Columns\RawColumn;

/**
 * Class Category
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="配置 ",
 *     name="config"
 * )
 */
class Config{

    /**
     * @FieldAttribute(
     *     label="主键",
     *     name="id",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $id;
    

    /**
     * @FieldAttribute(
     *     label="title",
     *     name="title",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $title;
    

    /**
     * @FieldAttribute(
     *     label="name",
     *     name="name",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $name;
    

    /**
     * @FieldAttribute(
     *     label="value",
     *     name="value",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $value;
    

    /**
     * @FieldAttribute(
     *     label="help",
     *     name="help",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $help;
    

    /**
     * @FieldAttribute(
     *     label="group_id",
     *     name="group_id",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $group_id;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $updated_at;
    

}