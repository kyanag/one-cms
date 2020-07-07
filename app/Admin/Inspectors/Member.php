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
 *     title="members",
 *     name="members"
 * )
 */
class Member{

    /**
     * @FieldAttribute(
     *     label="id",
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
     *     label="store_id",
     *     name="store_id",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $store_id;
    

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
     *     label="mobile",
     *     name="mobile",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $mobile;
    

    /**
     * @FieldAttribute(
     *     label="remark",
     *     name="remark",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $remark;
    

    /**
     * @FieldAttribute(
     *     label="deleted_at",
     *     name="deleted_at",
     *     ableTo=15,
     *     elementtype=Text::class,
     *
     *     column=@RawColumn()
     * )
     */
    public $deleted_at;
    

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