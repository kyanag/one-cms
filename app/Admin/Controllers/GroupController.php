<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Admin\Grid\Interfaces\InspectorInterface;

class GroupController extends _InspectorController
{
    protected function newModel()
    {
        return new Group();
    }

    public function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Group())
            ->built();
    }
}
