<?php


namespace App\Admin\Supports;


use App\Admin\Components\Nav;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use Kyanag\Form\Tabler\ElementFactory;

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

            $files = glob(base_path("vendor/kyanag/form/src/Tabler/Forms/*.php"));

            foreach($files as $file){
                $classBaseName = basename($file, ".php");
                $snake_str = \Kyanag\Form\camelToSnake($classBaseName);
                $class = "Kyanag\\Form\\Tabler\\Forms\\{$classBaseName}";

                $factory->registerComponent($snake_str, $class);
            }
            $factory->registerComponent("card-form", \Kyanag\Form\Tabler\CardForm::class);
            $factory->registerComponent("form", \Kyanag\Form\Tabler\Form::class);

            return $factory;
        });

        app()->singleton("objectBuilder", function(){
            return new ObjectBuilder();
        });
    }
}