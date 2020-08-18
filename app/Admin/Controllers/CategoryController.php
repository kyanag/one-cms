<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\Category;
use App\Supports\UrlCreator;
use Illuminate\Support\Str;

class CategoryController extends _InspectorController
{

    public function initialize()
    {
        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Category());

        $routeMain = Str::singular(
            Str::kebab(
                str_replace("Controller", "", class_basename($this))
            )
        );
        $this->urlCreator = new UrlCreator($routeMain);
    }
}
