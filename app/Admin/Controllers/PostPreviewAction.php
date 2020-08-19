<?php


namespace App\Admin\Controllers;


use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Supports\Tree;
use App\Supports\UrlCreator;

class PostPreviewAction extends Controller
{

    public function __invoke()
    {
        $categories = Category::query()->get();

        $tree = new Tree($categories->toArray(), "id", "parent_id");

        $urlCreator = new UrlCreator("post");

        return view("admin::post.preview", [
            'title' => "内容管理",
            'description' => "请选择栏目",
            'urlCreator' => $urlCreator,
            'categories' => $tree->toTreeList()
        ]);
    }

}