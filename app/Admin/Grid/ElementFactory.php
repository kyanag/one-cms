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
     * @throws \Exception
     */
    public function build(AttributeInspectorInterface $fieldInspector, $inputType, array $inputConfig = []){
        try{
            $callable = [$this, $inputType];
            if(is_callable($inputType)){
                $callable = $inputType;
            }
            return call_user_func_array($callable, [$fieldInspector, $inputConfig]);
        }catch (\BadMethodCallException $e){
            throw new \Exception("{$fieldInspector->getInspector()->getName()} :: {$fieldInspector->getName()} 表单对象配置不正确！");
        }
    }

    /**
     * @param AttributeInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
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
     * @param AttributeInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
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