<?php

use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use Kyanag\Form\Tabler\ElementFactory;

require_once app_path("./Admin/functions.php");

app('view')->prependNamespace('admin', resource_path('views/admin'));


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
    $factory->registerComponent("hidden", \Kyanag\Form\Tabler\Forms\Text::class);

    return $factory;
});


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


app()->singleton(\App\Admin\Grid\InspectorBuilder::class, function(){
    return new \App\Admin\Grid\InspectorBuilder(
        new \App\Admin\Grid\ColumnFactory(),
        new \App\Admin\Grid\ElementFactory()
    );
});