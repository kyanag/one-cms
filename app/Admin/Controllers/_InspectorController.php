<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\ColumnFactory;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Components\ActionBar;
use App\Admin\Components\GridView;
use App\Http\Controllers\Controller;
use App\Supports\Context;
use App\Admin\Supports\FormBuilder;
use App\Supports\UrlCreator;
use http\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

abstract class _InspectorController extends Controller
{

    public $pageSize = 10;

    /**
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * @var UrlCreator
     */
    protected $urlCreator;

    public function __construct()
    {
        app()->singleton(ColumnFactory::class, function(){
            $columnBuilder = new ColumnFactory();
            $columnBuilder->urlCreator = $this->urlCreator;

            return $columnBuilder;
        });
        $this->urlCreator = $this->createUrlCreator();
        $this->inspector = $this->createInspector();
    }

    /**
     * @return Model
     */
    protected function newModel(){
        $modelClass = $this->inspector->getModelClass();
        return new $modelClass;
    }

    protected function newQuery(){
        return $this->newModel()->newQuery();
    }

    /**
     * @return InspectorInterface
     */
    abstract protected function createInspector();

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

        return view("admin::common.create", compact("form", "title", "description"));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return Response
     * @throws HttpException
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(
            $request,
            $this->getRules(FieldAttribute::ABLE_CREATE),
            [],
            $this->getLabels()
        );

        $model = $this->newModel();
        $model->fill($attributes);

        if($model->saveOrFail()){
            return \response()->json([
                'msg' => "保存成功!",
                'jump' => $this->urlCreator->index(),
            ]);
        }else{
            throw new ServiceUnavailableHttpException();
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
        $model = $this->newModel()
            ->newQuery()->find($id);

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
        $formBuilder->setValue($model);

        $form = $formBuilder->built();

        $title = "{$model['title']} - 编辑{$this->inspector->getTitle()}";
        $description = "";

        return view("admin::common.edit", compact("form", "title", "description"));
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

    protected function getForm($scene){
        $form = createElement("form", [
            'id' => "OC-form-" . str_random(10),
        ]);

        /** @var FieldInspectorInterface $field */
        foreach ($this->inspector->getFields() as $field){
            if($field->ableFor($scene)){
                $form->addChild($field->toElement());
            }
        }
        return $form;
    }

    protected function getGrid(){
        $fieldInspectors = $this->inspector->getFields();

        $fieldInspectors = array_filter($fieldInspectors, function(FieldInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });

        $gridView = GridView::create([
            'caption' => "{$this->inspector->getTitle()} 列表",
            'columns' => array_map(function(FieldInspectorInterface $fieldInspector){
                return $fieldInspector->toColumn();
            }, $fieldInspectors),
        ]);
        return $gridView;
    }

    /**
     * @return UrlCreator
     */
    public function createUrlCreator(){
        $routeMain = Str::singular(
            Str::kebab(
                str_replace("Controller", "", class_basename($this))
            )
        );
        return new UrlCreator($routeMain);
    }


    public static function buildInspector($inspector){
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from($inspector)
            ->built();
    }
}