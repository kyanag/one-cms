<?php

namespace App\Providers;

use App\Admin\Components\Nav;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($event) {
            $query = $event;

            $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
            $qBindings = [];
            foreach ($query->bindings as $key => $value) {
                if (is_numeric($key)) {
                    $qBindings[] = $value;
                } else {
                    $tmp = str_replace(':'.$key, '"'.$value.'"', $tmp);
                }
            }
            $tmp = vsprintf($tmp, $qBindings);
            $tmp = str_replace("\\", "", $tmp);
            Log::info(' execution time: '.$query->time.'ms; '.$tmp."\n");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(config_path("_cloud.php"), "_cloud");

        $this->app->singleton("nav", function(){
            $nav = new Nav();
            $nav->items = [
                [
                    'icon' => "fa-file-text",
                    'title' => "HOME",
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
                    'icon' => "fa-file-text",
                    'title' => "测试一级栏目",
                    'url' => "#",
                    'children' => [
                        [
                            'icon' => "fa-file-text",
                            'title' => "测试二级栏目",
                            'url' => "#",
                        ],
                        [
                            'icon' => "fa-file-text",
                            'title' => "测试二级栏目2",
                            'url' => "#",
                            'children' => [
                                [
                                    'icon' => "fa-file-text",
                                    'title' => "测试三级栏目",
                                    'url' => "#",
                                ]
                            ],
                        ]
                    ],
                ]
            ];
            return $nav;
        });

        $this->app->singleton(AnnotationReader::class, function(){
            return new AnnotationReader();
        });
    }
}
