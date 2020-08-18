<?php


namespace App\Admin\Annotations;

/**
 * 运行时才知道的值
 * Class CallableAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class CallableAttribute
{

    /**
     * domain
     * @var object
     */
    public $host;

    /**
     * 必须是不带参数的方法
     * @var string
     */
    public $method;
}