<?php

namespace App\Admin\Controllers;

use App\Admin\Grid\ModelInspectorBuilder;

class CategoryController extends _InspectorController
{

    public function getInspector()
    {
        return app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Category())
            ->built();
    }
}
