<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\CallableAttribute;
use App\Admin\Grid\Columns\ActionColumn;
use App\Admin\Grid\Columns\CheckboxColumn;
use App\Admin\Grid\Columns\DataColumn;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Admin\Grid\Interfaces\ObjectBuilderProvider;
use Illuminate\Support\Traits\Macroable;

class ColumnBuilderProvider implements ObjectBuilderProvider
{

    use Macroable;

    public function create($name, $properties)
    {
        return $this->{$name}($properties);
    }

    public function checkbox(array $properties){
        return ObjectInitializer::initialize(new CheckboxColumn(), $properties);
    }

    /**
     * 原样值
     * @param FieldAttribute $fieldAttribute
     * @return GridColumnInterface
     */
    public function raw(array $properties){
        return ObjectInitializer::initialize(new DataColumn(), $properties);
    }


    /**
     * 选项值
     * @param FieldInspectorInterface $fieldInspector
     * @return DataColumn
     */
    public function using(array $properties){
        $dataColumn = new DataColumn();

        $dataColumn->content = function($model, $key, $index) use($properties){
            /** @var array $options */
            $options = $properties['options'];
            $name = (array)$key;

            return implode("-", array_map(function($name) use($model, $options){
                $value = $model[$name];
                return @$options[$value] ?: "-";
            }, $name));
        };
        return ObjectInitializer::initialize($dataColumn, $properties);
    }

    public function action(array $properties){
        $actionColumn = new ActionColumn();
        return ObjectInitializer::initialize($actionColumn, $properties);
    }
}