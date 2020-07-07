<?php


namespace App\Admin\Grid;


use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use Kyanag\Form\Toolkits\Bootstrap3\Select;
use Kyanag\Form\Traits\Macroable;
use Kyanag\Form\Toolkits\Bootstrap3\Radio;
use Kyanag\Form\Toolkits\Bootstrap3\Text;

class ElementBuilder
{
    use Macroable;


    public function text(FieldInspectorInterface $fieldInspector){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        return new Text($name, $label);
    }

    public function radio(FieldInspectorInterface $fieldInspector){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $options = $fieldInspector->getOriginAttributes()->inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }

        return new Radio($name, $label, $options);
    }

    public function select(FieldInspectorInterface $fieldInspector){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $options = $fieldInspector->getOriginAttributes()->inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }
        return new Select($name, $label, $options);
    }

    /**
     * 外键字段
     * @param FieldInspectorInterface $fieldInspector
     */
    public function belongsTo(FieldInspectorInterface $fieldInspector){
        $name = $fieldInspector->getName();
        $label = $fieldInspector->getLabel();

        $inputConfig = $fieldInspector->getOriginAttributes()->inputConfig['options'];
        $inputType = @$inputConfig['inputType'] ?: "select";

        $relationName = @$inputConfig['relationName'];
        $modelClass = $fieldInspector->getSchema()->modelClass();

        $relation = relation_extract($modelClass, $relationName);
    }
}