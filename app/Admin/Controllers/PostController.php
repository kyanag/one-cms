<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Admin\Supports\FormCreator;
use App\Models\Category;
use App\Models\Post;

class PostController extends _InspectorBasedController
{

    /** @var Category */
    private $category;

    public function initialize()
    {
        $category = Category::query()
            ->where("id", app("request")->input("category_id"))
            ->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }

        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Post());

        $this->activeRelatedNames = [
            $category['type']
        ];

        $urlCreator = createUrlCreator(class_basename($this));
        $urlCreator->setDefaultQuery([
            'category_id' => $category['id']
        ]);
        $this->urlCreator = $urlCreator;

        Post::saving(function($model) use($category){
            $model->category_id = $category->id;
            return $model;
        });

        $this->category = $category;
    }

    protected function getForm($scene)
    {
        return (new FormCreator($this->inspector, $this->activeRelatedNames))
            ->toForm($scene);
    }

    protected function newQuery()
    {
        return parent::newQuery()->where("category_id", $this->category['id']);
    }
}
