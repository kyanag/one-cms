<?php


namespace App\Admin\Components;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Supports\FormBuilder;
use App\Admin\Grid\Interfaces\InspectorInterface;
use Kyanag\Form\Renderable;


/**
 * Class SearchBar
 * @package App\Admin\Components
 * @mixin FormBuilder
 */
class SearchBar implements Renderable
{

    /**
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * @var FormBuilder
     */
    protected $formBuilder;

    public function __construct(InspectorInterface $inspector)
    {
        $this->inspector = $inspector;
    }

    public function getFormBuilder(){
        if(!$this->formBuilder){
            $form = FormBuilder::newForm();

            $fields = $this->inspector->getAttributes();

            /** @var AttributeInspectorInterface $field */
            foreach ($fields as $field){
                if($field->ableFor(FieldAttribute::ABLE_SEARCH)){
                    $form->addChild($field->toElement());
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
        $columns = array_map(function(AttributeInspectorInterface $column){
            return $column->ableFor(FieldAttribute::ABLE_SEARCH);
        }, $this->inspector->getAttributes());

        $scope = function($query) use($columns, $params){
            /** @var AttributeInspectorInterface $column */
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