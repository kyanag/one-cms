<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\User;

class UserController extends _InspectorController
{

    public function initialize()
    {
        return Factory::buildInspector(new \App\Admin\Inspectors\User());
    }
}
