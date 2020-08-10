<?php


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
    return app("elementFactory")->createElement($type, $props, $children);
}