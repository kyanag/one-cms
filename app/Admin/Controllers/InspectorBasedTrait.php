<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\RelationAttribute;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Admin\Supports\Factory;
use App\Admin\Supports\FormCreator;
use App\Http\Controllers\Controller;
use App\Supports\UrlCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * Trait InspectorBasedTrait
 * @package App\Admin\Controllers
 * @mixin Controller
 */
trait InspectorBasedTrait
{

    /**
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * @var array<string>
     */
    protected $activeRelatedNames = [];

    /**
     * @var UrlCreator
     */
    protected $urlCreator;


    /**
     * @return Model
     */
    protected function newModel(){
        $modelClass = $this->inspector->getModelClass();
        return new $modelClass;
    }

    protected function newQuery(){
        return $this->newModel()->newQuery()->with($this->activeRelatedNames);
    }

    protected function getValidator(Request $request, $scene){
        $rules = [];
        $labels = [];

        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $rules[$attribute->getName()] = $attribute->getRules();

                $labels[$attribute->getName()] = $attribute->getLabel();
            }
        }

        foreach ($this->activeRelatedNames as $activeRelationName){
            /** @var RelationInspectorInterface $relationInspector */
            if($relationInspector = $this->inspector->getRelation($activeRelationName)){
                $foreignInspector = $relationInspector->getForeignInspector();

                $keyPathPrefix = "{$activeRelationName}";
                if($relationInspector->getRelationshipType() === RelationAttribute::RELATION_HAS_MANY){
                    $keyPathPrefix = "{$activeRelationName}.*";
                }

                /** @var FieldInspectorInterface $attribute */
                foreach ($foreignInspector->getFields() as $attribute){
                    if($attribute->ableFor($scene)){

                        $rules["{$keyPathPrefix}.{$attribute->getName()}"] = $attribute->getRules();

                        $labels["{$keyPathPrefix}.{$attribute->getName()}"] = $attribute->getLabel();
                    }
                }
            }
        }
        return $this->getValidationFactory()
            ->make($request->all(), $rules, [], $labels);
    }


    protected function getForm($scene){
        return (new FormCreator($this->inspector, $this->activeRelatedNames))
            ->toForm($scene);
    }


    protected function getGrid(){
        return Factory::grid($this->inspector, []);
    }
}