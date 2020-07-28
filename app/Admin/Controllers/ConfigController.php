<?php

namespace App\Admin\Controllers;

use App\Admin\Inspectors\ConfigItems;
use App\Models\Config;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends _InspectorController
{
    protected function newModel()
    {
        return new Config();
    }

    public function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Config())
            ->built();
    }


    public function preview(Request $request){
        /** @var \Illuminate\Session\Store $session */
        $session = app("session")->driver();

        $inspector = app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new ConfigItems())
            ->built();

        $fields = $inspector->getAttributes();
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
