<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;

class MemberController extends _InspectorController
{

    /**
     * @return Member
     */
    protected function newModel(){
        return new Member();
    }


    public function getInspector()
    {
        return new ModelInspectorInterface(new \App\Admin\Inspectors\Member());
    }




}
