<?php


namespace App\Admin\Annotations;

use App\Admin\Supports\Readable;

/**
 * Class ColumnAttribute
 * @package App\Admin\Annotations
 * @Annotation
 */
class ColumnAttribute extends Readable
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
    public $column;


    /**
     * 控件参数
     * @var array
     */
    public $columnArgs = [];


    public function setFieldAttribute(FieldAttribute $fieldAttribute){
        $this->fieldAttribute = $fieldAttribute;
    }

    public function setInspector($inspector){
        $this->inspector = $inspector;
    }

}