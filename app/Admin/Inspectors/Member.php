<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\SchemaAttribute;

/**
 * Class Member
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="members",
 *     name="members",
 *     modelClass=\App\Models\Member::class
 * )
 */
class Member extends Readable{

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
     *     label="store_id",
     *     name="store_id",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $store_id;
    

    /**
     * @FieldAttribute(
     *     label="name",
     *     name="name",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $name;
    

    /**
     * @FieldAttribute(
     *     label="mobile",
     *     name="mobile",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $mobile;
    

    /**
     * @FieldAttribute(
     *     label="remark",
     *     name="remark",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $remark;
    

    /**
     * @FieldAttribute(
     *     label="deleted_at",
     *     name="deleted_at",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $deleted_at;
    

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