<?php


namespace App\Admin\Grid;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Columns\ActionColumn;
use App\Admin\Grid\Columns\CheckboxColumn;
use App\Admin\Grid\Columns\DataColumn;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\GridColumnInterface;
use App\Supports\UrlCreator;
use Kyanag\Form\Traits\Macroable;

class ColumnBuilder
{

    use Macroable;

    /**
     * @var UrlCreator
     */
    public $urlCreator;


    public function checkbox(FieldInspectorInterface $fieldInspector){
        $checkboxColumn = new CheckboxColumn();

        $checkboxColumn->name = $fieldInspector->getName();
        $checkboxColumn->label = $fieldInspector->getLabel();
        $checkboxColumn->decorators = @$fieldInspector->getOriginAttributes()->columnConfig['decorators'] ?: [];

        return $checkboxColumn;
    }

    /**
     * 原样值
     * @param FieldAttribute $fieldAttribute
     * @return GridColumnInterface
     */
    public function raw(FieldInspectorInterface $fieldInspector){
        $dataColumn = new DataColumn();

        $dataColumn->name = $fieldInspector->getName();
        $dataColumn->label = $fieldInspector->getLabel();
        $dataColumn->decorators = @$fieldInspector->getOriginAttributes()->columnConfig['decorators'] ?: [];

        return $dataColumn;
    }


    /**
     * 选项值
     * @param FieldInspectorInterface $fieldInspector
     * @return DataColumn
     */
    public function using(FieldInspectorInterface $fieldInspector){
        $dataColumn = new DataColumn();
        $dataColumn->name = $fieldInspector->getName();
        $dataColumn->label = $fieldInspector->getLabel();
        $dataColumn->decorators = @$fieldInspector->getOriginAttributes()->columnConfig['decorators'] ?: [];

        $columnConfig = $fieldInspector->getOriginAttributes()->columnConfig;

        $options = $columnConfig['options'] ?: [];
        $defaultView = @$columnConfig['defaultView'] ?: "-";
        $includeSign = @$columnConfig['includeSign'] ?: "-";

        $dataColumn->content = function($model, $key, $index) use($options, $defaultView, $includeSign){
            /** @var GridColumnInterface $this */
            if(is_object($options) && method_exists($options, "toArray")){
                $options = $options->toArray();
            }
            $name = (array)($this->getName());

            return implode($includeSign, array_map(function($name) use($model, $options, $defaultView){
                $value = $model[$name];
                return @$options[$value] ?: $defaultView;
            }, $name));
        };
        return $dataColumn;
    }

    public function action(FieldInspectorInterface $fieldInspector){
        $actionColumn = new ActionColumn();

        $actionColumn->name = $fieldInspector->getName();
        $actionColumn->label = $fieldInspector->getLabel();
        $actionColumn->decorators = @$fieldInspector->getOriginAttributes()->columnConfig['decorators'] ?: [];

        $columnConfig = $fieldInspector->getOriginAttributes()->columnConfig;
        if(isset($columnConfig['template'])){
            $actionColumn->template = $columnConfig['template'];
        }
        $actionColumn->urlCreator = $this->urlCreator;
        return $actionColumn;
    }
}