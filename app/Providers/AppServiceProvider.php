<?php

namespace App\Providers;

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

        $this->app->singleton(AnnotationReader::class, function(){
            return new AnnotationReader();
        });
    }
}
