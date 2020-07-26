<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class PostController extends _InspectorController
{

    protected function getInspector()
    {
        return app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Post())
            ->built();
    }
}
