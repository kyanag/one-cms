<?php

use App\Admin\Grid\Interfaces\AttributeInspectorInterface;

app('view')->prependNamespace('admin', resource_path('views/admin'));


\App\Admin\Grid\ColumnFactory::macro("usingCategories", function(AttributeInspectorInterface $fieldInspector, array $columnConfig){
    $categories = Category::select(
        "id", "parent_id", "title"
    )->get();

    $tree = new Tree($categories->toArray());

    $items = $tree->toTreeList();

    $options = [
        0 => "根"
    ];

    foreach ($items as $item){
        $options[$item['id']] = str_repeat("—— ", $item['depth']) .  " {$item['title']}";
    }
    return $options;
});


app()->singleton(\App\Admin\Grid\ModelInspectorBuilder::class, function(){
    return new \App\Admin\Grid\ModelInspectorBuilder(
        new \App\Admin\Grid\ColumnFactory(),
        new \App\Admin\Grid\ElementFactory()
    );
});