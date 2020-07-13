<?php


namespace App\Admin\Grid;


use App\Admin\Grid\Interfaces\AttributeInspectorInterface;

use Kyanag\Form\Traits\Macroable;
use Kyanag\Form\Interfaces\Renderable;
use Kyanag\Form\Toolkits\Bootstrap3\Select;
use Kyanag\Form\Toolkits\Bootstrap3\Radio;
use Kyanag\Form\Toolkits\Bootstrap3\Text;

class ElementFactory
{
    use Macroable;

    /**
     * @param AttributeInspectorInterface $fieldInspector
     * @param $inputType
     * @param array $inputConfig
     * @return Renderable
     */
    public function build(AttributeInspectorInterface $fieldInspector, $inputType, array $inputConfig = []){
        return $this->{$inputType}($fieldInspector, $inputConfig);
    }


    public function text(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        return new Text($name, $label);
    }

    public function radio(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $options = $inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }

        return new Radio($name, $label, $options);
    }

    public function select(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $options = $inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }
        return new Select($name, $label, $options);
    }

    /**
     * 外键字段
     * @param AttributeInspectorInterface $fieldInspector
     */
    public function belongsTo(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $inputType = @$inputConfig['inputType'] ?: "select";

        $relationName = @$inputConfig['relationName'];
        $modelClass = $fieldInspector->getSchema()->modelClass();

        $relation = relation_extract($modelClass, $relationName);
    }
}