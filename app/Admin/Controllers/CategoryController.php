<?php

namespace App\Admin\Controllers;

use App\Admin\Grid\ModelInspectorBuilder;
use App\Models\Category;

class CategoryController extends _InspectorController
{

    public function getInspector()
    {
        return app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Category())
            ->built();
    }

    protected function newModel()
    {
        return new Category();
    }
}
