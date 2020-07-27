<?php


namespace App\Admin\Providers;


use Illuminate\Support\ServiceProvider;

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


        app()->singleton(\App\Admin\Grid\ModelInspectorBuilder::class, function(){
            return new \App\Admin\Grid\ModelInspectorBuilder(
                new \App\Admin\Grid\ColumnFactory(),
                new \App\Admin\Grid\ElementFactory()
            );
        });
    }
}