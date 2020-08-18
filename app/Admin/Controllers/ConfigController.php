<?php

namespace App\Admin\Controllers;

use App\Admin\Inspectors\ConfigItems;
use App\Admin\Supports\Factory;
use App\Models\Config;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Models\Group;
use App\Supports\UrlCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConfigController extends _InspectorController
{

    public function initialize()
    {
        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Config());

        $routeMain = Str::singular(
            Str::kebab(
                str_replace("Controller", "", class_basename($this))
            )
        );
        $this->urlCreator = new UrlCreator($routeMain);
    }


    public function preview(Request $request){
        $inspector = Factory::buildInspector(new \App\Admin\Inspectors\ConfigItems());

        $fields = $inspector->getFields();
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
