<?php


namespace App\Admin\Supports;


use App\Admin\Components\Nav;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use Kyanag\Form\Components\ElementFactory;

class Admin
{

    public function __construct()
    {
    }


    public function setup(){
        require_once app_path("./Admin/functions.php");

        app('view')->prependNamespace('admin', resource_path('views/admin'));

        app()->singleton("nav", function(){
            $nav = new Nav();
            $nav->items = [
                [
                    'icon' => "fa-home",
                    'title' => "管理首页",
                    'url' => route("admin.home"),
                ],
                [
                    'icon' => "fa-users",
                    'title' => "栏目",
                    'url' => route("admin.category.index"),
                ],
                [
                    'icon' => "fa-users",
                    'title' => "会员",
                    'url' => route("admin.member.index"),
                ],
                [
                    'icon' => "fa-file",
                    'title' => "内容",
                    'url' => route("admin.post.preview"),
                ],
                [
                    'icon' => "fa-users",
                    'title' => "系统",
                    'url' => route("admin.config.preview"),
                    'children' => [
                        [
                            'icon' => "fa-users",
                            'title' => "配置",
                            'url' => route("admin.config.preview"),
                        ]
                    ],
                ],
            ];
            return $nav;
        });


        app()->singleton("elementFactory", function(){
            $factory = new ElementFactory();

            $files = glob(base_path("vendor/kyanag/form/src/Components/Forms/*.php"));

            foreach($files as $file){
                $classBaseName = basename($file, ".php");
                $snake_str = \Kyanag\Form\camelToSnake($classBaseName);
                $class = "Kyanag\\Form\\Components\\Forms\\{$classBaseName}";

                $factory->registerComponent($snake_str, $class);
            }
            $factory->registerComponent("card-form", \Kyanag\Form\Components\CardForm::class);
            $factory->registerComponent("form", \Kyanag\Form\Components\Form::class);

            return $factory;
        });

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