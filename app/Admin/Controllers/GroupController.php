<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;

class GroupController extends _InspectorController
{
    protected function newModel()
    {
        return new Group();
    }

    public function getInspector()
    {
        return app(\App\Admin\Grid\ModelInspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Group())
            ->built();
    }
}
