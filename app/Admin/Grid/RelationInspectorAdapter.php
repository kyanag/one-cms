<?php


namespace App\Admin\Grid;


use App\Admin\Grid\Interfaces\InspectorInterface;

class RelationInspectorAdapter
{
    /**
     * @var InspectorInterface
     */
    protected $inspector;

    public function __construct(InspectorInterface $inspector)
    {
        $this->inspector = $inspector;
    }

}