<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\Group;
use App\Admin\Grid\Interfaces\InspectorInterface;

class GroupController extends _InspectorBasedController
{

    public function initialize()
    {
        return Factory::buildInspector(new \App\Admin\Inspectors\Group());
    }
}
