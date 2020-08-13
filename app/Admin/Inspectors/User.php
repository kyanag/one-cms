<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;

/**
 * Class User
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="管理员",
 *     name="users",
 *     modelClass=\App\Models\User::class
 * )
 */
class User{

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
     *     label="账号",
     *     name="username",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $username;
    

    /**
     * @FieldAttribute(
     *     label="管理员名称",
     *     name="nickname",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $nickname;
    

    /**
     * @FieldAttribute(
     *     label="邮箱",
     *     name="email",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $email;
    

    /**
     * @FieldAttribute(
     *     label="password",
     *     name="password",
     *     ableTo=0,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $password;
    

    /**
     * @FieldAttribute(
     *     label="remember_token",
     *     name="remember_token",
     *     ableTo=0,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public $remember_token;
    

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


    /**
     * @FieldAttribute(
     *     label="操作",
     *     name="id",
     *     ableTo=1,
     *     columnType="action"
     * )
     */
    public $_actionBar;
}