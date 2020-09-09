<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Admin\Supports\FormCreator;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PostController extends _InspectorBasedController
{

    /** @var Category */
    private $category;


    public function initialize()
    {
        /** @var Model $category */
        $category = Category::query()
            ->where("id", app("request")->input("category_id"))
            ->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }

        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Post());

        $this->activeRelations = [
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

        $this->pastePapers = $this->category->form_bindings->where("bind_type", 1);

        Post::addGlobalScope(function($query)use($category){
            return $query->where("category_id", $category['id']);
        });
    }
}
