<?php


namespace App\Admin\Grid\Decorators;


/**
 * Class BadgeDecorator
 * @package App\Admin\Grid\Decorators
 * @Annotation
 */
class BadgeDecorator
{

    /**
     * @var string
     */
    public $type = "success";

    public function __invoke($values)
    {
        return "<span class=\"badge badge-{$this->type}\">{$values}</span>";
    }

}