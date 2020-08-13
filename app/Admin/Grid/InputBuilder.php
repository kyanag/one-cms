<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\InputAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use Illuminate\Contracts\Support\Renderable;

class InputBuilder
{
    /**
     * @var \Kyanag\Form\Tabler\ElementFactory
     */
    protected $inputFactory;

    /**
     * @param InputAttribute $inputAttribute
     * @return Renderable
     */
    public function build(InputAttribute $inputAttribute){

    }

    public function compile(InputAttribute $inputAttribute){

    }
}