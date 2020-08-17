<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\Category;

class CategoryController extends _InspectorController
{

    public function createInspector()
    {
        return Factory::buildInspector(new \App\Admin\Inspectors\Category());
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Category())
            ->built();
    }

    protected function newModel()
    {
        return new Category();
    }
}
