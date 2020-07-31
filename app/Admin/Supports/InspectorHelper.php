<?php


namespace App\Admin\Supports;


use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use Illuminate\Database\Eloquent\Model;

class InspectorHelper
{

    /**
     * @param InspectorInterface $inspector
     * @param $input
     * @param $scene
     * @return array|mixed
     */
    public static function filterByInspector(InspectorInterface $inspector, $input, $scene){
        $attributes = $inspector->getAttributes();
        if(!is_null($scene)){
            $attributes = array_filter($attributes, function(AttributeInspectorInterface $attributeInspector) use($scene){
                return $attributeInspector->ableFor($scene);
            });
        }

        $out = [];
        /** @var AttributeInspectorInterface $attribute */
        foreach ($attributes as $attribute){
            if(isset($input[$attribute->getName()])){
                $out[$attribute->getName()] = $input[$attribute->getName()];
            }
        }
        return $out;
    }

    /**
     * @param InspectorInterface $inspector
     * @return Model
     */
    public static function newModel(InspectorInterface $inspector){
        $className = $inspector->getModelClass();
        $model = new $className();
        return $model;
    }
}