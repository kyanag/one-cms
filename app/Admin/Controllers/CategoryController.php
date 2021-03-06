<?php

namespace App\Admin\Controllers;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Supports\Factory;
use App\Admin\Supports\FormBuilder;
use App\Admin\Supports\FormCreator;
use App\Models\Category;
use App\Models\FormBinding;
use App\Supports\UrlCreator;
use Illuminate\Support\Str;

class CategoryController extends _InspectorBasedController
{

    public function initialize()
    {
        $this->activeRelations = [
            "form_bindings"
        ];

        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Category());

        $routeMain = Str::singular(
            Str::kebab(
                str_replace("Controller", "", class_basename($this))
            )
        );
        $this->urlCreator = new UrlCreator($routeMain);

        FormBinding::saving(function($model){
            $model->entity_type = (new Category())->getTable();
        });
    }

    public function create()
    {
        $form = $this->getForm(FieldAttribute::ABLE_CREATE);
        $formBuilder = new FormBuilder($form);
        $formBuilder->setMethod("POST");
        $formBuilder->setAction(
            $this->urlCreator->store()
        );

        $form = $formBuilder->built();

        $title = "新增{$this->inspector->getTitle()}";
        $description = "";

        $urlCreator = $this->urlCreator;
        return view("admin::common.create", [
            'title' => $title,
            'description' => $description,
            'form' => $form,
            'urlCreator' => $urlCreator,
            'scene' => FieldAttribute::ABLE_CREATE
        ]);
    }

    protected function getForm($scene)
    {
        return (new FormCreator($this->inspector, $this->activeRelations))->toForm($scene);
    }
}
