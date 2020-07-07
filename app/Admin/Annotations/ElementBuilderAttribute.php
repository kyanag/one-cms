<?php


namespace App\Admin\Annotations;

/**
 * Class ElementBuilderAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class ElementBuilderAttribute
{

    /**
     * @required
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $label;

    /**
     * classname
     * @var string
     */
    public $elementtype;

    /**
     * 选项
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $help = null;


    public function build(){

    }
}