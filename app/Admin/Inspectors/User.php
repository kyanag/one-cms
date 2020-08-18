<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\SchemaAttribute;

/**
 * Class User
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="users",
 *     name="users",
 *     modelClass="\App\Models\User"
 * )
 */
class User{

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
     *     label="username",
     *     name="username",
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
    public $username;
    

    /**
     * @FieldAttribute(
     *     label="nickname",
     *     name="nickname",
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
    public $nickname;
    

    /**
     * @FieldAttribute(
     *     label="email",
     *     name="email",
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
    public $email;
    

    /**
     * @FieldAttribute(
     *     label="password",
     *     name="password",
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
    public $password;
    

    /**
     * @FieldAttribute(
     *     label="remember_token",
     *     name="remember_token",
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
    public $remember_token;
    

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
    

}