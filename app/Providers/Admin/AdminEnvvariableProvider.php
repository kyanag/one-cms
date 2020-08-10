<?php

namespace App\Providers\Admin;

use App\Admin\Components\Breadcrumb;
use App\Models\Store;
use Illuminate\Support\ServiceProvider;

/**
 * 应用环境变量
 * Class AdminEnvvariableProvider
 * @package App\Providers\Admin
 */
class AdminEnvvariableProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        define("DESC_QUERY_NAME", "_descBy");
        define("ASC_QUERY_NAME", "_ascBy");


        $this->mergeConfigFrom(config_path("constant.php"), "constant");

        $this->app->singleton("env.store", function(){
            return $this->mockStore();
        });

        $this->setBreadcrumb(); //admin 公共面包屑导航
    }

    private function setBreadcrumb(){
        $this->app->singleton("breadcrumb", function(){
            $breadcrumb = new Breadcrumb();
            return $breadcrumb;
        });
    }

    protected function mockStore(){
        $attributes = [
            'id' => 0,
            'title' => "默认门店",
        ];
        $store = new Store($attributes);
        $store->exists = true;

        return $store;
    }
}
