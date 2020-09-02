<?php


namespace App\Admin\Facades;


use App\Admin\Supports\InputBuilderProvider;
use App\Models\Category;
use App\Supports\Tree;
use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \App\Admin\Supports\Admin::class;
    }


    public static function navs(){
        return [
            [
                'icon' => "fa-home",
                'title' => "首页",
                'url' => route("admin.home"),
            ],
            [
                'icon' => "fa-users",
                'title' => "栏目",
                'url' => route("admin.category.index"),
            ],
            [
                'icon' => "fa-users",
                'title' => "会员",
                'url' => route("admin.member.index"),
            ],
            [
                'icon' => "fa-shopping-cart",
                'title' => "交易",
                'url' => "",
                'children' => [
                    [
                        'icon' => "fa-shopping-cart",
                        'title' => "商品",
                        'url' => route("admin.config.preview"),
                    ],
                    [
                        'icon' => "fa-file-invoice-dollar",
                        'title' => "订单",
                        'url' => route("admin.config.preview"),
                    ],
                ],
            ],
            [
                'icon' => "fa-users",
                'title' => "系统",
                'url' => route("admin.config.preview"),
                'children' => [
                    [
                        'icon' => "fa-users",
                        'title' => "配置",
                        'url' => route("admin.config.preview"),
                    ],
                    [
                        'icon' => "fa-users",
                        'title' => "表单",
                        'url' => route("admin.form.index"),
                    ]
                ],
            ],
        ];
    }

    public static function categories(){
        $categories = Category::query()->get();

        $tree = new Tree($categories->toArray(), "id", "parent_id");
        return $tree->toTreeList();
    }


    public static function createElement($type, $props = []){
        return app(InputBuilderProvider::class)->create($type, $props);
    }
}