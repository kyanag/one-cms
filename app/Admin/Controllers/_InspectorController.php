<?php


namespace App\Admin\Controllers;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\ColumnBuilder;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Components\ActionBar;
use App\Components\GridView;
use App\Http\Controllers\Controller;
use App\Supports\Context;
use App\Supports\FormBuilder;
use App\Admin\Grid\InspectorReader;
use App\Supports\UrlCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

abstract class _InspectorController extends Controller
{

    public function __construct()
    {
        app()->singleton(ColumnBuilder::class, function(){
            $columnBuilder = new ColumnBuilder();
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
    protected function getModel(){
        $modelClass = $this->getInspector()->modelClass();
        return new $modelClass();
    }

    /**
     * @return InspectorReader
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
        $title = " {$this->getInspector()->title()}列表";
        $description = "{$this->getInspector()->title()}管理";

        $actionBar = new ActionBar($this->getInspector(), $this->getUrlCreator());
        $actionBar->setQuery($request->query());

        /** @var Paginator $paginator */
        $paginator = $this->getModel()
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

        $title = "新增{$this->getInspector()->title()}";
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
            $this->getInspector()->getRules(FieldAttribute::ABLE_CREATE),
            [],
            $this->getInspector()->getLabels()
        );

        $model = $this->getModel();
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
        $model = $this->getModel()
            ->newQuery()->find($id);

        if(is_null($model)){
            flash("不存在的{$this->getInspector()->title()}", "warning");
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

        $title = "{$model['title']} - 编辑{$this->getInspector()->title()}";
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
        foreach ($this->getInspector()->fields() as $field){
            if($field->ableFor($scene)){
                $form->addComponent($field->toElement());
            }
        }
        return $form;
    }

    protected function getGrid(){
        $fields = $this->getInspector()->fields();

        $fields = array_filter($fields, function(FieldInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });

        $gridView = GridView::create([
            'caption' => "{$this->getInspector()->title()} 列表",
            'columns' => array_map(function(FieldInspectorInterface $fieldInspector){
                return $fieldInspector->toColumn();
            }, $fields),
        ]);
        return $gridView;
    }


    public function getContext(){
        if(is_null($this->context)){
            $context = new Context();
            $context->set(UrlCreator::class, UrlCreator::createByModel($this->getModel()));

            $this->context = $context;
        }
        return $this->context;
    }

    public function getUrlCreator(){
        return $this->getContext()[UrlCreator::class];
    }
}