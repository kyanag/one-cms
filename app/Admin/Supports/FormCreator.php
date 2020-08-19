<?php


namespace App\Admin\Supports;


use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use Kyanag\Form\Component;
use Kyanag\Form\Tabler\Form;
use Kyanag\Form\Tabler\Forms\HasOne;

class FormCreator
{

    /**
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * @var array<RelationInspectorInterface>
     */
    protected $activeRelations = [];


    public function __construct(InspectorInterface $inspector, $activeRelations = [])
    {
        $this->inspector = $inspector;
        $this->activeRelations = $activeRelations;
    }

    /**
     * @param $scene int enum(FieldAttribute::$ABLE)
     * @return Component
     */
    public function toForm($scene, $valueDomain = null){
        /** @var Form $form */
        $form = \createElement("form", [
            'id' => "OC-form-" . str_random(10),
        ]);

        /** @var FieldInspectorInterface $field */
        foreach ($this->inspector->getFields() as $field){
            if($field->ableFor($scene)){
                $form->addChild($field->toElement());
            }
        }

        /** @var RelationInspectorInterface $relation */
        foreach ($this->activeRelations as $relation){
            if($component = $this->buildComponentFormRelationInspector($relation, $scene)){
                $form->addChild($component);
            }
        }
        return $form;
    }

    /**
     * @param $scene
     * @return HasOne
     */
    public function toNestableForm($scene, $valueDomain = null){
        /** @var HasOne $form */
        $form = \createElement("has-one", [
            'id' => "OC-form-" . str_random(10),
            'name' => $valueDomain,
            'label' => $this->inspector->getTitle(),
        ]);

        /** @var FieldInspectorInterface $field */
        foreach ($this->inspector->getFields() as $field){
            if($field->ableFor($scene)){
                /** @var Component $component */
                $component = $field->toElement();
                if(!is_null($valueDomain)){
                    $component->name = "{$valueDomain}.{$component->name}";
                }

                $form->addChild($component);
            }
        }

        /** @var RelationInspectorInterface $relation */
        foreach ($this->activeRelations as $relation){
            if($component = $this->buildComponentFormRelationInspector($relation, $scene)){
                $form->addChild($component);
            }
        }
        return $form;
    }

    /**
     * @param string $relationName
     * @return Component
     */
    protected function buildComponentFormRelationInspector($relationName, $scene){
        /** @var RelationInspectorInterface $relationInspector */
        $relationInspector = $this->inspector->getRelations()[$relationName];

        $static = new static($relationInspector->getForeignInspector(), []);
        return $static->toNestableForm($scene, $relationName);
    }
}