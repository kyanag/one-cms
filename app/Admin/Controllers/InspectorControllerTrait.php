<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Components\ActionBar;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Admin\Repositories\BasicInspectorRepository;
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
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;


/**
 * Trait InspectorControllerTrait
 * @package App\Admin\Controllers
 * @mixin Controller
 */
trait InspectorControllerTrait
{

    /**
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * @var array<string>
     */
    protected $activeRelations = [];

    /**
     * @var UrlCreator
     */
    protected $urlCreator;


    protected $repository;

    /**
     * @http
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
        $paginator = $this->getRepository()->getQuery()
            //->where($actionBar->toScope())
            ->withGlobalScope("__runtime__", $actionBar->toScope())
            ->paginate(static::PAGE_SIZE);
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
     * @http
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws HttpException
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request, FieldAttribute::ABLE_CREATE);

        if($validator->fails() === false){
            $inputs = $this->extractInputFromRules($request, $validator->getRules());
            DB::beginTransaction();
            try{
                $model = $this->getRepository()->create($inputs);

                DB::commit();
                return \response()->json([
                    'msg' => "保存成功!",
                    'jump' => $this->urlCreator->index(),
                ]);
            }catch (\Exception $e){
                DB::rollback();
                throw new ServiceUnavailableHttpException(null, $e->getMessage(), $e);
            }
        }else{
            throw new ValidationException($validator);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $model = $this->getRepository()->find($id);

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
     * @throws ValidationException
     * @throws HttpException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var Model $model */
        $model = $this->getRepository()->find($id);
        if(is_null($model)){
            flash("不存在的{$this->inspector->getTitle()}", "warning");
            throw new NotFoundHttpException("不存在的{$this->inspector->getTitle()}");
        }

        $validator = $this->getValidator($request, FieldAttribute::ABLE_CREATE);

        if($validator->fails() === false) {
            $inputs = $this->extractInputFromRules($request, $validator->getRules());

            DB::beginTransaction();
            try{
                $model = $this->getRepository()->updateModel($inputs, $model);
                DB::commit();
                return \response()->json([
                    'msg' => "保存成功!",
                    'jump' => $this->urlCreator->index(),
                ]);
            }catch (\Exception $e){
                DB::rollback();
                throw new ServiceUnavailableHttpException(null, $e->getMessage(), $e);
            }
        }else{
            throw new ValidationException($validator);
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
        $model = $this->getRepository()->find($id);
        if(is_null($model)){
            throw new NotFoundHttpException("不存在的内容!");
        }

        DB::transaction(function() use($model){
            $this->getRepository()->deleteModel($model);
        });
        return response()->json([
            'msg' => "删除成功!",
            'jump' => $request->header("REFERER"),
        ]);
    }

    /**
     * @http
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
     * @param Request $request
     * @param $scene
     * @return \Illuminate\Contracts\Validation\Validator|Validator
     */
    protected function getValidator(Request $request, $scene){
        $rules = [];
        $labels = [];

        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $rules[$attribute->getName()] = $attribute->getRules();

                $labels[$attribute->getName()] = $attribute->getLabel();
            }
        }

        foreach ($this->activeRelations as $activeRelationName){
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
        return $this->getValidationFactory()
            ->make($request->all(), $rules, [], $labels);
    }

    public function getRepository(){
        if(!$this->repository){
            $this->repository = new BasicInspectorRepository($this->inspector, $this->activeRelations, []);
        }
        return $this->repository;
    }

    protected function getForm($scene){
        return (new FormCreator($this->inspector, $this->activeRelations))
            ->toForm($scene);
    }


    protected function getGrid(){
        return Factory::grid($this->inspector, []);
    }
}