<?php

namespace App\Admin\Controllers;

use App\Admin\Supports\Factory;
use App\Models\Member;

class MemberController extends _InspectorController
{

    public function initialize()
    {
        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Member());

        $this->urlCreator = createUrlCreator(class_basename($this));
    }
}
