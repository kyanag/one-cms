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
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;


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
    protected $activeRelatedNames = [];

    /**
     * @var UrlCreator
     */
    protected $urlCreator;


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
        $paginator = $this->newQuery()
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
     * @return Model
     */
    protected function newModel(){
        $modelClass = $this->inspector->getModelClass();
        return new $modelClass;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery(){
        return $this->newModel()->newQuery()->with($this->activeRelatedNames);
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
        return $this->getValidationFactory()
            ->make($request->all(), $rules, [], $labels);
    }

    public function getRepository(){
        //TODO
    }

    protected function getForm($scene){
        return (new FormCreator($this->inspector, $this->activeRelatedNames))
            ->toForm($scene);
    }


    protected function getGrid(){
        return Factory::grid($this->inspector, []);
    }
}