<?php

namespace App\Admin\Controllers;

use App\Models\Category;

class PostController extends _InspectorController
{

    /** @var Category */
    private $category;

    protected function getInspector()
    {
        $inspector = app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Post())
            ->built();

        $category = Category::query()->where("id", app("request")->input("category_id"))->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }

        $this->category = $category;

        $category->type;
        return $inspector;
    }


    protected function
}
