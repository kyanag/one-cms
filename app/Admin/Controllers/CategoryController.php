<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Admin\Grid\InspectorReader;

class CategoryController extends _InspectorController
{

    protected function getModel()
    {
        return new Category();
    }

    public function getInspector()
    {
        return new InspectorReader(new \App\Admin\Inspectors\Category());
    }
}
