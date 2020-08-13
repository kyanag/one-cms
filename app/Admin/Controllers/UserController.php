<?php

namespace App\Admin\Controllers;

use App\Models\User;

class UserController extends _InspectorController
{

    public function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\User())
            ->built();
    }

    protected function newModel()
    {
        return new User();
    }
}
