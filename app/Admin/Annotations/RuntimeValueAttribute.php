<?php


namespace App\Admin\Annotations;

/**
 * 运行时才知道的值
 * Class RuntimeValueAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class RuntimeValueAttribute
{

    /**
     * 宿主
     * @var object
     */
    public $host;

    /**
     * @var string
     */
    public $callable;
}