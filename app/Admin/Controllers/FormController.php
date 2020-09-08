<?php

namespace App\Admin\Controllers;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Supports\Factory;
use App\Models\Form;
use App\Supports\UrlCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class FormController extends _InspectorBasedController
{

    protected $activeRelations = [
        "inputs"
    ];

    protected function initialize()
    {
        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Form());
        $routeMain = Str::singular(
            Str::kebab(
                str_replace("Controller", "", class_basename($this))
            )
        );
        $this->urlCreator = new UrlCreator($routeMain);
    }


    public function store(Request $request)
    {

        $attributes = $this->validateForInspector(
            $request,
            FieldAttribute::ABLE_CREATE
        );
        /** @var \App\Models\Form $model */
        $model = $this->newModel();
        $model->fill($attributes);

        $inputModels = array_map(function($input){
            return new \App\Models\FormInput($input);
        }, $attributes['inputs']);
        DB::beginTransaction();
        try{
            if(!$model->save()){
                throw new ServiceUnavailableHttpException();
            }
            foreach ($inputModels as $inputModel){
                if(!$model->inputs()->save($inputModel)){
                    throw new ServiceUnavailableHttpException();
                }
            }
            DB::commit();
            return \response()->json([
                'msg' => "保存成功!",
                'jump' => $this->urlCreator->index(),
            ]);
        }catch (\Exception $e){
            DB::rollback();
            throw new ServiceUnavailableHttpException(null, $e->getMessage(), $e);
        }
    }


    public function generate(Request $request){
        $form_id = $request->input("form_id");
        $valueDomain = $request->input("value_domain", "extends");

        /** @var Form $formRecord */
        $formRecord = Form::find($form_id);
        if(is_null($formRecord)){
            throw new NotFoundHttpException("不存在的表单！");
        }

        $form = $formRecord->toFormSection();
    }
}
