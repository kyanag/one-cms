<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Components\ActionBar;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Admin\Supports\Factory;
use App\Admin\Supports\FormBuilder;
use App\Admin\Supports\FormCreator;
use App\Http\Controllers\Controller;
use App\Supports\UrlCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

abstract class _InspectorBasedController extends Controller
{

    use InspectorBasedTrait;


    public $pageSize = 10;

    /**
     * @return void
     */
    abstract protected function initialize();


    public function callAction($method, $parameters)
    {
        $this->initialize();
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $grid = $this->getGrid();
        $title = " {$this->inspector->getTitle()}列表";
        $description = "{$this->inspector->getTitle()}管理";

        $actionBar = new ActionBar($this->inspector, $this->urlCreator);
        $actionBar->setQuery($request->query());

        /** @var Paginator $paginator */
        $paginator = $this->newQuery()
            //->where($actionBar->toScope())
            ->withGlobalScope("__runtime__", $actionBar->toScope())
            ->paginate($this->pageSize);
        $grid->items = $paginator->getCollection();

        $paginator->withPath(
            $this->urlCreator->index()
        );
        $paginator->appends($request->query());

        return view("admin::common.index", compact(
            "title",
            "description",
            "grid",
            "paginator",
            "actionBar"
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
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
        return view("admin::common.create", compact("form", "title", "description", "urlCreator"));
    }


    public function store(Request $request)
    {

        $inputs = $this->validateForInspector(
            $request,
            FieldAttribute::ABLE_CREATE
        );
        /** @var \App\Models\Form $model */
        $model = $this->newModel();
        $model->fill($inputs);

        DB::beginTransaction();
        try{
            if(!$model->save()){
                throw new ServiceUnavailableHttpException();
            }

            foreach ($this->activeRelatedNames as $activeRelatedName){
                /** @var RelationInspectorInterface $relationInspector */
                $relationInspector = $this->inspector->getRelation($activeRelatedName);
                $foreignInspector = $relationInspector->getForeignInspector();

                $modelClass = $foreignInspector->getModelClass();

                if($relationInspector->getRelationshipType() === RelationAttribute::RELATION_HAS_MANY){

                    foreach ($inputs[$activeRelatedName] as $attributes){
                        if(!$model->{$activeRelatedName}()->save(new $modelClass($attributes))){
                            throw new ServiceUnavailableHttpException();
                        }
                    }
                }else{
                    if(!$model->{$activeRelatedName}()->save(new $modelClass($inputs[$activeRelatedName]))){
                        throw new ServiceUnavailableHttpException();
                    }
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $model = $this->newQuery()->find($id);

        if(is_null($model)){
            flash("不存在的{$this->inspector->getTitle()}", "warning");
            return back();
        }

        $form = $this->getForm(FieldAttribute::ABLE_UPDATE);

        $formBuilder = new FormBuilder($form);
        $formBuilder->setMethod("PUT", true);
        $formBuilder->setAction(
            $this->urlCreator->update(["id" => $id])
        );
        $formBuilder->setValue($model->toArray());

        $form = $formBuilder->built();

        $title = "{$model['title']} - 编辑{$this->inspector->getTitle()}";
        $description = "";

        $urlCreator = $this->urlCreator;

        return view("admin::common.edit", compact("form", "title", "description", "urlCreator"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $model = $this->newQuery()->find($id);
        if(is_null($model)){
            flash("不存在的{$this->inspector->getTitle()}", "warning");
            throw new NotFoundHttpException("不存在的{$this->inspector->getTitle()}");
        }

        $attributes = $this->validate(
            $request,
            $this->getRules(FieldAttribute::ABLE_CREATE),
            [],
            $this->getLabels()
        );
        $model->fill($attributes);

        if($model->saveOrFail()){
            return \response()->json([
                'msg' => "编辑成功!",
                'jump' => $this->urlCreator->edit($id)
            ]);
        }else{
            throw new ServiceUnavailableHttpException();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        /** @var Model $model */
        $model = $this->newQuery()->find($id);
        if(is_null($model)){
            throw new NotFoundHttpException("不存在的内容!");
        }

        DB::transaction(function() use($model){
            if(!$model->delete()){
                throw new ServiceUnavailableHttpException("删除失败，请重试!");
            }
        });
        return response()->json([
            'msg' => "删除成功!",
            'jump' => $request->header("REFERER"),
        ]);
    }

    protected function getRules($scene){
        $rules = [];
        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $rules[$attribute->getName()] = $attribute->getRules();
            }
        }


        return $rules;
    }

    protected function getLabels(){
        $labels = [];
        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            $labels[$attribute->getName()] = $attribute->getLabel();
        }
        return $labels;
    }


    protected function validateForInspector(Request $request, $scene)
    {
        $rules = [];
        $labels = [];

        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $rules[$attribute->getName()] = $attribute->getRules();

                $labels[$attribute->getName()] = $attribute->getLabel();
            }
        }

        foreach ($this->activeRelatedNames as $activeRelationName){
            /** @var RelationInspectorInterface $relationInspector */
            if($relationInspector = $this->inspector->getRelation($activeRelationName)){
                $foreignInspector = $relationInspector->getForeignInspector();

                $keyPathPrefix = "{$activeRelationName}";
                if($relationInspector->getRelationshipType() === RelationAttribute::RELATION_HAS_MANY){
                    $keyPathPrefix = "{$activeRelationName}.*";
                }

                /** @var FieldInspectorInterface $attribute */
                foreach ($foreignInspector->getFields() as $attribute){
                    if($attribute->ableFor($scene)){

                        $rules["{$keyPathPrefix}.{$attribute->getName()}"] = $attribute->getRules();

                        $labels["{$keyPathPrefix}.{$attribute->getName()}"] = $attribute->getLabel();
                    }
                }
            }
        }
        return $this->validate($request, $rules, [], $labels);
    }

}