<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Columns\ActionColumn;
use App\Admin\Grid\Columns\CheckboxColumn;
use App\Admin\Grid\Columns\DataColumn;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Supports\UrlCreator;
use Illuminate\Support\Traits\Macroable;

class ColumnFactory
{

    use Macroable;

    /**
     * @var UrlCreator
     */
    public $urlCreator;

    /**
     * @param FieldInspectorInterface $fieldInspector
     * @param $columnType
     * @param array $columnConfig
     * @return GridColumnInterface
     */
    public function build(FieldInspectorInterface $fieldInspector, $columnType, array $columnConfig = []){
        return $this->{$columnType}($fieldInspector, $columnConfig);
    }


    public function belongTo(FieldInspectorInterface $fieldInspector, array $columnConfig = []){

    }


    public function checkbox(FieldInspectorInterface $fieldInspector, array $columnConfig){
        $checkboxColumn = new CheckboxColumn();

        $checkboxColumn->name = $fieldInspector->getName();
        $checkboxColumn->label = $fieldInspector->getLabel();
        $checkboxColumn->decorators = @$columnConfig['decorators'] ?: [];

        return $checkboxColumn;
    }

    /**
     * 原样值
     * @param FieldAttribute $fieldAttribute
     * @return GridColumnInterface
     */
    public function raw(FieldInspectorInterface $fieldInspector, array $columnConfig){
        $dataColumn = new DataColumn();

        $dataColumn->name = $fieldInspector->getName();
        $dataColumn->label = $fieldInspector->getLabel();
        $dataColumn->decorators = @$columnConfig['decorators'] ?: [];

        return $dataColumn;
    }


    /**
     * 选项值
     * @param FieldInspectorInterface $fieldInspector
     * @return DataColumn
     */
    public function using(FieldInspectorInterface $fieldInspector, array $columnConfig){
        $dataColumn = new DataColumn();
        $dataColumn->name = $fieldInspector->getName();
        $dataColumn->label = $fieldInspector->getLabel();
        $dataColumn->decorators = @$columnConfig['decorators'] ?: [];

        $columnConfig['options'] = $columnConfig['options'] ?: [];
        $columnConfig['defaultView'] = @$columnConfig['defaultView'] ?: "-";
        $columnConfig['includeSign'] = @$columnConfig['includeSign'] ?: "-";

        $dataColumn->content = function($model, $key, $index) use($fieldInspector, $columnConfig){
            /** @var GridColumnInterface $this */
            if(is_object($columnConfig['options']) && method_exists($columnConfig['options'], "toArray")){
                $columnConfig['options'] = $columnConfig['options']->toArray();
            }
            $name = (array)$key;

            return implode($columnConfig['includeSign'], array_map(function($name) use($model, $columnConfig){
                $value = $model[$name];
                return @$columnConfig['options'][$value] ?: $columnConfig['defaultView'];
            }, $name));
        };
        return $dataColumn;
    }

    public function action(FieldInspectorInterface $fieldInspector, array $columnConfig){

        $actionColumn = new ActionColumn();

        $actionColumn->name = $fieldInspector->getName();
        $actionColumn->label = $fieldInspector->getLabel();
        $actionColumn->decorators = @$columnConfig['decorators'] ?: [];

        $actionColumn->urlCreator = $this->urlCreator;

        if(isset($columnConfig['template'])){
            $actionColumn->template = $columnConfig['template'];
        }
        return $actionColumn;
    }
}