<?php


namespace App\Admin\Supports;



use Kyanag\Form\Components\Decorators\ColumnDecorator;
use Kyanag\Form\Components\FormSection;

class Admin
{

    public function __construct()
    {
    }


    public function setup(){
        require_once app_path("./Admin/functions.php");

        app('view')->prependNamespace('admin', resource_path('views/admin'));

        app()->singleton(InputBuilderProvider::class, function(){
            $inputProvider = new InputBuilderProvider();

            $files = glob(base_path("vendor/kyanag/form/src/Components/Forms/*.php"));

            foreach($files as $file){
                $classBaseName = basename($file, ".php");
                $snake_str = \Kyanag\Form\camelToSnake($classBaseName);
                $class = "Kyanag\\Form\\Components\\Forms\\{$classBaseName}";

                $inputProvider->registerComponent($snake_str, $class);
            }
            $inputProvider->registerComponent("card-form", \Kyanag\Form\Components\CardForm::class);
            $inputProvider->registerComponent("form", \Kyanag\Form\Components\Form::class);
            $inputProvider->registerComponent("form-section", FormSection::class);

            $inputProvider->registerComponent("column", ColumnDecorator::class);
            return $inputProvider;
        });

        app()->singleton(ObjectCreator::class, function(){
            $objectCreator = new ObjectCreator();
            //表单构造器
            $objectCreator->register("input", app(InputBuilderProvider::class));
            //grid 列构造器
            $objectCreator->register("column", app(ColumnBuilderProvider::class));

            return $objectCreator;
        });
    }
}