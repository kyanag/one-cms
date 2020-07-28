<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use App\Admin\Grid\Interfaces\InspectorInterface;

class MemberController extends _InspectorController
{

    public function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Member())
            ->built();
    }

    protected function newModel()
    {
        return new Member();
    }
}
