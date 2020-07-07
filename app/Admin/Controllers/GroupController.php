<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Admin\Grid\InspectorReader;

class GroupController extends _InspectorController
{
    protected function getModel()
    {
        return new Group();
    }

    public function getInspector()
    {
        return new InspectorReader(new \App\Admin\Inspectors\Group());
    }
}
