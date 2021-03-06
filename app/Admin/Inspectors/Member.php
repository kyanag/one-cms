<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\CallableAttribute;
use App\Admin\Annotations\FieldAttribute;
use App\Admin\Supports\Readable;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Supports\UrlCreator;

/**
 * Class Member
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="会员",
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
     *     label="store_id",
     *     name="store_id",
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
    public $store_id;
    

    /**
     * @FieldAttribute(
     *     label="name",
     *     name="name",
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
    public $name;
    

    /**
     * @FieldAttribute(
     *     label="mobile",
     *     name="mobile",
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
    public $mobile;
    

    /**
     * @FieldAttribute(
     *     label="remark",
     *     name="remark",
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
    public $remark;
    

    /**
     * @FieldAttribute(
     *     label="deleted_at",
     *     name="deleted_at",
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
    public $deleted_at;
    

    /**
     * @FieldAttribute(
     *     label="created_at",
     *     name="created_at",
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
    public $created_at;
    

    /**
     * @FieldAttribute(
     *     label="updated_at",
     *     name="updated_at",
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
        $urlCreator = new UrlCreator("member");
        return $urlCreator;
    }
}