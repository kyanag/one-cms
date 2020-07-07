<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use App\Admin\Grid\InspectorReader;

class MemberController extends _InspectorController
{

    /**
     * @return Member
     */
    protected function getModel(){
        return new Member();
    }


    public function getInspector()
    {
        return new InspectorReader(new \App\Admin\Inspectors\Member());
    }




}
