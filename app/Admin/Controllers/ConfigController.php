<?php

namespace App\Admin\Controllers;

use App\Admin\Inspectors\ConfigItems;
use App\Models\Config;
use App\Admin\Grid\InspectorReader;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        /** @var \Illuminate\Session\Store $session */
        $session = app("session")->driver();
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

    public function updateAll(Request $request){
        $configs = Config::query()->get()->keyBy("name");
        $params = $request->input();
        try{
            DB::transaction(function() use($configs, $params){
                foreach ($configs as $name => $config){
                    if(isset($params[$name])){
                        $config->value = $params[$name];
                        $config->save();
                    }
                }
            });
            return "修改成功";
        }catch (\Exception $e){

        }
    }
}
