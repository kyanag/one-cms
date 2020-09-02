<?php


use App\Admin\Supports\InputBuilderProvider;
use Illuminate\Support\Str;
use Kyanag\Form\Renderable;

function admin_path($dir){
    return app_path("Admin/{$dir}");
}


/**
 * @param $type
 * @param array $props
 * @param array $children
 * @return \Kyanag\Form\Component
 */
function createElement($type, $props = [], $children = []){
    return app(InputBuilderProvider::class)->create($type, $props, $children);
}


function createUrlCreator($classname){
    $routeMain = Str::singular(
        Str::kebab(
            str_replace("Controller", "", $classname)
        )
    );
    return new \App\Supports\UrlCreator($routeMain);
}