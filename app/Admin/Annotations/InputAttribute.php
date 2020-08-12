<?php


namespace App\Admin\Annotations;

use App\Admin\Supports\Readable;

/**
 * Class InputBuilder
 * @package App\Admin\Annotations
 * @Annotation
 */
class InputAttribute extends Readable
{

    /**
     * @var FieldAttribute
     */
    private $fieldAttribute;

    /**
     * @var object
     */
    private $inspector;

    /**
     * 控件类型
     * @var string
     */
    public $widget;


    /**
     * 控件参数
     * @var array
     */
    public $widgetArgs = [];


    public function setFieldAttribute(FieldAttribute $fieldAttribute){
        $this->fieldAttribute = $fieldAttribute;
    }

    public function setInspector($inspector){
        $this->inspector = $inspector;
    }
}