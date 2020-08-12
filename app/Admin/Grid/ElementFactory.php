<?php


namespace App\Admin\Grid;


use App\Admin\Grid\Elements\Editor;
use App\Admin\Grid\Elements\WangEditor;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Renderable;

class ElementFactory
{
    use Macroable;

    /**
     * @param FieldInspectorInterface $fieldInspector
     * @param $inputType
     * @param array $inputConfig
     * @return Renderable
     * @throws \Exception
     */
    public function build(FieldInspectorInterface $fieldInspector, $inputType, array $inputConfig = []){
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
     * @param FieldInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function text(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("text", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function staticText(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("static-text", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    /**
     * @param FieldInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function textarea(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("textarea", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function editor(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("editor", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function wangEditor(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("textarea", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function radio(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        $options = $inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }

        return createElement("radio", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
            'options' => $options,
        ]);
    }

    public function select(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        $options = $inputConfig['options'];
        if (is_object($options) && method_exists($options, "toIterator")){
            $options = $options->toIterator();
        }

        return createElement("select", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
            'options' => $options,
        ]);
    }

    /**
     * @param FieldInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function hasOne(FieldInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("has-one", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }
}