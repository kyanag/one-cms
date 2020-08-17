<?php


namespace App\Admin\Supports;


use App\Admin\Grid\Interfaces\ObjectBuilderProvider;
use Kyanag\Form\Supports\ComponentBuilder;

class InputBuilderProvider implements ObjectBuilderProvider
{

    protected $components = [];


    public function create($type, $properties)
    {
        if (isset($this->components[$type])) {
            $class = $this->components[$type];
            $name = @$properties['name'];
            $label = @$properties['label'];

            unset($properties['name'], $properties['label'], $properties['attribute']);

            $componentBuilder = new ComponentBuilder(new $class($name, $label));
            foreach ($properties as $name => $propValue) {
                $componentBuilder->setProperty($name, $propValue);
            }
            return $componentBuilder->built();
        }
        return null;
    }



    public function registerComponent($name, $class)
    {
        $this->components[$name] = $class;
    }
}