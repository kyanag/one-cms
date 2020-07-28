<?php

namespace App\Admin\Controllers;

use App\Admin\Grid\InspectorBuilder;
use App\Models\Category;

class CategoryController extends _InspectorController
{

    public function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Category())
            ->built();
    }

    protected function newModel()
    {
        return new Category();
    }
}
