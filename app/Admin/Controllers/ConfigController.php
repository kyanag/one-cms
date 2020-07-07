<?php

namespace App\Admin\Controllers;

use App\Admin\Inspectors\ConfigItems;
use App\Models\Config;
use App\Admin\Grid\InspectorReader;
use App\Models\Group;
use Illuminate\Http\Request;

class ConfigController extends _InspectorController
{
    protected function getModel()
    {
        return new Config();
    }

    public function getInspector()
    {
        return new InspectorReader(new \App\Admin\Inspectors\Config());
    }


    public function preview(Request $request){
        $inspector = new InspectorReader(new ConfigItems());

        $fields = $inspector->fields();
        $groups = Group::forConfig()
            ->with("configs")
            ->get();

        $fields = collect($fields)->keyBy(function($field){
            return $field->getName();
        });

        return view("admin::config.preview", [
            'title' => "系统设置",
            'fields' => $fields,
            'groups' => $groups,
        ]);
    }
}
