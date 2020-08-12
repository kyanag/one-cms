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