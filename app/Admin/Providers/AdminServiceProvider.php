<?php


namespace App\Admin\Providers;


use Illuminate\Support\ServiceProvider;
use Kyanag\Form\Tabler\ElementFactory;

class AdminServiceProvider extends ServiceProvider
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
    }



}