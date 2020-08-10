<?php


namespace App\Admin\Providers;


use Illuminate\Support\ServiceProvider;
use Kyanag\Form\Tabler\ElementFactory;

class AdminProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app('view')->prependNamespace('admin', resource_path('views/admin'));


        app()->singleton(\App\Admin\Grid\InspectorBuilder::class, function(){
            return new \App\Admin\Grid\InspectorBuilder(
                new \App\Admin\Grid\ColumnFactory(),
                new \App\Admin\Grid\ElementFactory()
            );
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
            $factory->registerComponent("form", \Kyanag\Form\Tabler\Form::class);


            return $factory;
        });
    }
}