<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\User;

class UserController extends _InspectorBasedController
{

    public function initialize()
    {
        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\User());

        $this->urlCreator = createUrlCreator(class_basename($this));
    }
}
