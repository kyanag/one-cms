<?php

namespace App\Admin\Controllers;

use App\Admin\Grid\InspectorAdapter;
use App\Models\Category;
use App\Models\Post;

class PostController extends _InspectorController
{

    /** @var Category */
    private $category;

    protected function getInspector()
    {
        /** @var InspectorAdapter $inspector */
        $inspector = app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Post())
            ->built();

        $category = Category::query()->where("id", app("request")->input("category_id"))->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }
        $this->category = $category;

        $inspector->appendInspector();

        return $inspector;
    }


    protected function newModel()
    {
        return new Post();
    }

    protected function newQuery()
    {
        return $this->newModel()->load($this->category['type']);
    }
}
