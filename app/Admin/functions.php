<?php


function admin_path($dir){
    return app_path("Admin/{$dir}");
}


/**
 * @param $modelClass
 * @param $relation
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Relations\HasMany
 */
function relation_extract($modelClass, $relation){
    $model = new $modelClass;
    return $model->{$relation}();
}