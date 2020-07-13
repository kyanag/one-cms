<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\ColumnFactory;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;
use App\Components\ActionBar;
use App\Components\GridView;
use App\Http\Controllers\Controller;
use App\Supports\Context;
use App\Supports\FormBuilder;
use App\Supports\UrlCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

abstract class _InspectorController extends Controller
{

    /**
     * @var ModelInspectorInterface
     */
    protected $modelInspector;

    public function __construct()
    {
        $this->modelInspector = $this->getInspector();

        app()->singleton(ColumnFactory::class, function(){
            $columnBuilder = new ColumnFactory();
            $columnBuilder->urlCreator = $this->getUrlCreator();

            return $columnBuilder;
        });



    }


    /**
     * @var UrlCreator
     */
    protected $urlCreator;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @return Model
     */
    protected function newModel(){
        $modelClass = $this->modelInspector->getModelClass();
        return new $modelClass();
    }

    /**
     * @return ModelInspectorInterface
     */
    abstract protected function getInspector();

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $grid = $this->getGrid();
        $title = " {$this->modelInspector->getTitle()}列表";
        $description = "{$this->modelInspector->getTitle()}管理";

        $actionBar = new ActionBar($this->modelInspector, $this->getUrlCreator());
        $actionBar->setQuery($request->query());

        /** @var Paginator $paginator */
        $paginator = $this->newModel()
            ->newQuery()
            //->where($actionBar->toScope())
            ->withGlobalScope("__runtime__", $actionBar->toScope())
            ->paginate(10);
        $grid->items = $paginator->getCollection();

        $paginator->withPath(
            $this->getUrlCreator()->index()
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
            $this->getUrlCreator()->store()
        );

        $form = $formBuilder->built();

        $title = "新增{$this->modelInspector->getTitle()}";
        $description = "";

        return view("admin::common.create", compact("form", "title", "description"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(
            $request,
            $this->modelInspector->getRules(FieldAttribute::ABLE_CREATE),
            [],
            $this->modelInspector->getLabels()
        );

        $model = $this->newModel();
        $model->fill($attributes);

        if($model->saveOrFail()){
            return \response()->json("保存成功!");
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
            flash("不存在的{$this->modelInspector->getTitle()}", "warning");
            return back();
        }

        $form = $this->getForm(FieldAttribute::ABLE_UPDATE);

        $formBuilder = new FormBuilder($form);
        $formBuilder->setMethod("PUT", true);
        $formBuilder->setAction(
            $this->getUrlCreator()->update(["id" => $id])
        );
        $formBuilder->setValue($model);

        $form = $formBuilder->built();

        $title = "{$model['title']} - 编辑{$this->modelInspector->getTitle()}";
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
        var_dump(111);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getForm($scene){
        $form = FormBuilder::newForm();

        /** @var FieldAttribute $field */
        foreach ($this->modelInspector->getAttributes() as $field){
            if($field->ableFor($scene)){
                $form->addComponent($field->toElement());
            }
        }
        return $form;
    }

    protected function getGrid(){
        $attributeInspectors = $this->modelInspector->getAttributes();

        $attributeInspectors = array_filter($attributeInspectors, function(AttributeInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });

        $gridView = GridView::create([
            'caption' => "{$this->modelInspector->getTitle()} 列表",
            'columns' => array_map(function(AttributeInspectorInterface $fieldInspector){
                return $fieldInspector->toColumn();
            }, $attributeInspectors),
        ]);
        return $gridView;
    }


    public function getContext(){
        if(is_null($this->context)){
            $context = new Context();
            $context->set(UrlCreator::class, UrlCreator::createByModel($this->newModel()));

            $this->context = $context;
        }
        return $this->context;
    }

    public function getUrlCreator(){
        return $this->getContext()[UrlCreator::class];
    }
}