<?php


namespace App\Components;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Supports\FormBuilder;
use App\Admin\Grid\InspectorReader;
use Kyanag\Form\Interfaces\Renderable;


/**
 * Class SearchBar
 * @package App\Components
 * @mixin FormBuilder
 */
class SearchBar implements Renderable
{

    /**
     * @var InspectorReader
     */
    protected $inspector;

    /**
     * @var FormBuilder
     */
    protected $formBuilder;

    public function __construct(InspectorReader $inspector)
    {
        $this->inspector = $inspector;
    }

    public function getFormBuilder(){
        if(!$this->formBuilder){
            $form = FormBuilder::newForm();

            $fields = $this->inspector->fields();

            /** @var FieldInspectorInterface $field */
            foreach ($fields as $field){
                if($field->ableFor(FieldAttribute::ABLE_SEARCH)){
                    $form->addComponent($field->toElement());
                }
            }
            $this->formBuilder = new FormBuilder($form);
        }
        return $this->formBuilder;
    }

    public function __call($name, $arguments)
    {
        return $this->getFormBuilder()->{$name}(...$arguments);
    }

    public function render(){
        return $this->getFormBuilder()->built()->render();
    }

    /**
     * @deprecated
     * @param array $params
     * @return \Closure
     */
    public function createScope($params = []){
        $columns = array_map(function(FieldInspectorInterface $column){
            return $column->ableFor(FieldAttribute::ABLE_SEARCH);
        }, $this->inspector->fields());

        $scope = function($query) use($columns, $params){
            /** @var FieldInspectorInterface $column */
            foreach($columns as $column){
                if(isset($params[$column->getName()]) && $params[$column->getName()] !== ""){
                    $query->where($column->getName(), "like", "%{$params[$column->getName()]}%");
                }
            }
            return $query;
        };
        return $scope;
    }
}