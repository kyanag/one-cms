<?php


namespace App\Admin\Grid\Decorators;


/**
 * Class LabelDecorator
 * @package App\Admin\Grid\Decorators
 * @Annotation
 */
class LabelDecorator
{

    /**
     * @var string
     */
    public $type = "success";

    public function __invoke($values)
    {
        return "<span class=\"label label-{$this->type}\">{$values}</span>";
    }

}