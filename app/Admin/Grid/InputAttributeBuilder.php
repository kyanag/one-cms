<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\InputAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use Illuminate\Contracts\Support\Renderable;

class InputAttributeBuilder
{

    public function build(InputAttribute $inputAttribute){

    }


    /**
     * @param AttributeInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function text(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("text", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function staticText(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("static-text", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    /**
     * @param AttributeInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function textarea(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("textarea", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function editor(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("editor", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function wangEditor(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("textarea", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }

    public function radio(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
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

    public function select(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
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
     * @param AttributeInspectorInterface $fieldInspector
     * @param array $inputConfig
     * @return Renderable
     */
    public function hasOne(AttributeInspectorInterface $fieldInspector, array $inputConfig = []){
        return createElement("has-one", [
            'name' => $fieldInspector->getName(),
            'label' => $fieldInspector->getLabel(),
        ]);
    }
}